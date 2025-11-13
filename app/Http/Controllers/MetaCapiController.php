<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MetaCapiController extends Controller
{
        public function handle(Request $request)
    {
        $data = $request->all();

        $access_token = env('META_ACCESS_TOKEN');
        $pixel_id = env('META_PIXEL_ID');

        $response = Http::post("https://graph.facebook.com/v18.0/{$pixel_id}/events", [
            'data' => [[
                'event_name' => 'Purchase',
                'event_time' => time(),
                'event_id' => $data['event_id'],
                'action_source' => 'website',
                'user_data' => [
                    'em' => hash('sha256', $data['customer']['email']),
                    'ph' => hash('sha256', $data['customer']['phone']),
                ],
                'custom_data' => [
                    'value' => $data['value'],
                    'currency' => $data['currency'],
                    'order_id' => $data['order_id'],
                ]
            ]],
            'access_token' => $access_token
        ]);

        return response()->json($response->json());
    }
}
