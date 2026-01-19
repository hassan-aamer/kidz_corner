<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendMetaPurchaseEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 30;

    /**
     * The order instance.
     */
    protected Order $order;

    /**
     * The client IP address.
     */
    protected string $clientIp;

    /**
     * The client user agent.
     */
    protected string $userAgent;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order, string $clientIp, string $userAgent)
    {
        $this->order = $order;
        $this->clientIp = $clientIp;
        $this->userAgent = $userAgent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pixelId = config('services.meta.pixel_id', '1099641122366792');
        $accessToken = config('services.meta.access_token', 'EAAV1VhkDeZCwBP26FcfNsERr8bgE0fZAWXCTd314fYzBkKYWjLWQubtk8BqpyZCJXqdF1VVwt0W4jBh3ZAIZBnmT0vQkOuCj2ypBQvhNS19bLydGZAjveHMdipFyNZCD31sicN8qRuUUTWQPffY4woGi6OGBA90kHiCk91PwAlAaWlaiPXrNjr5kmAUwiyJdgZDZD');

        // Prepare hashed user data
        $userData = [
            'client_ip_address' => $this->clientIp,
            'client_user_agent' => $this->userAgent,
        ];

        // Only add email if exists
        if ($this->order->email) {
            $userData['em'] = hash('sha256', strtolower(trim($this->order->email)));
        }

        // Only add phone if exists
        if ($this->order->phone) {
            $userData['ph'] = hash('sha256', preg_replace('/\D/', '', $this->order->phone));
        }

        // Event data
        $eventData = [
            'data' => [
                [
                    'event_name' => 'Purchase',
                    'event_time' => $this->order->created_at->timestamp,
                    'action_source' => 'website',
                    'event_id' => 'order_' . $this->order->id,
                    'user_data' => $userData,
                    'custom_data' => [
                        'currency' => 'EGP',
                        'value' => (float) $this->order->total,
                        'order_id' => $this->order->id,
                    ]
                ]
            ]
        ];

        try {
            $response = Http::timeout(10)->post(
                "https://graph.facebook.com/v17.0/{$pixelId}/events?access_token={$accessToken}",
                $eventData
            );

            if ($response->successful()) {
                Log::info('Meta CAPI: Purchase event sent successfully', [
                    'order_id' => $this->order->id,
                    'response' => $response->json(),
                ]);
            } else {
                Log::warning('Meta CAPI: Failed to send purchase event', [
                    'order_id' => $this->order->id,
                    'status' => $response->status(),
                    'response' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Meta CAPI: Exception while sending purchase event', [
                'order_id' => $this->order->id,
                'error' => $e->getMessage(),
            ]);

            // Re-throw to trigger retry
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Meta CAPI: Job failed after all retries', [
            'order_id' => $this->order->id,
            'error' => $exception->getMessage(),
        ]);
    }
}
