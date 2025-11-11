<?php

namespace App\Http\Controllers\Web;

use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Services\Categories\CategoryService;

class OrderController extends Controller
{
    protected CategoryService $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function getAreas($cityId)
    {
        $areas = City::where('parent_id', $cityId)->get();
        return response()->json($areas);
    }

    public function getShipping(Request $request)
    {
        $cityId = $request->city_id;

        $city = City::find($cityId);

        if ($city) {
            return response()->json([
                'shipping_price' => $city->shipping_price ?? 0
            ]);
        }

        return response()->json([
            'shipping_price' => 0
        ]);
    }

    private function getCart()
    {
        $sessionId = session()->getId();

        return Cart::firstOrCreate([
            'session_id' => $sessionId
        ]);
    }

    public function index()
    {
        $cart = $this->getCart()->load('items.product');

        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $cities = City::where('parent_id', null)->Publish()->get()->sortBy('position');
        return view('web.pages.order', compact('cart', 'total', 'cities'));
    }
    public function storeOrder(Request $request)
    {
        try {

            DB::beginTransaction();
            $cart = $this->getCart()->load('items.product');

            if (empty($cart)) {
                return redirect()->back()->with('error', 'The basket is empty');
            }

            $area = City::find($request->area_id);

            $order = Order::create([
                'session_id'          => session()->getId(),
                'total'               => $request->total,
                'status'              => 'pending',
                'payment_method'      => $request->payment_method,
                'payment_status'      => 'pending',
                'address'             => $request->address,
                'phone'               => $request->phone,
                'another_phone'       => $request->another_phone ?? null,
                'email'               => $request->email ?? null,
                'city_id'             => $request->city_id,
                'area_id'             => $request->area_id,
                'full_name'           => $request->full_name,
                'shipping_price'      => $area ? $area->shipping_price : 0,
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // if ($order->email) {
            //     Mail::send(new \App\Mail\OrderCreatedCustomer($order));
            // }

            // Mail::send(new \App\Mail\OrderCreatedAdmin($order));

            return redirect()->route('thanks', $order->id)
                ->with('success', 'The order was created successfully 🎉');
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }


    public function thanks($orderId)
    {
        $order = Order::findOrFail($orderId);
        $this->sendPurchaseEvent($order);
        return view('web.pages.thanks', compact('order'));
    }





    public function sendPurchaseEvent($order)
    {
        // dd($order);
        $pixel_id = 1099641122366792;
        $access_token = 'EAAV1VhkDeZCwBP26FcfNsERr8bgE0fZAWXCTd314fYzBkKYWjLWQubtk8BqpyZCJXqdF1VVwt0W4jBh3ZAIZBnmT0vQkOuCj2ypBQvhNS19bLydGZAjveHMdipFyNZCD31sicN8qRuUUTWQPffY4woGi6OGBA90kHiCk91PwAlAaWlaiPXrNjr5kmAUwiyJdgZDZD'; // ضع Access Token هنا

        // تجهيز بيانات العميل مشفرة SHA256
        $user_data = [
            'em' => hash('sha256', strtolower(trim($order->email))),
            'ph' => hash('sha256', preg_replace('/\D/', '', $order->phone)),
            'client_ip_address' => request()->ip(),
            'client_user_agent' => request()->userAgent()
        ];

        // بيانات الحدث
        $event_data = [
            'data' => [
                [
                    'event_name' => 'Purchase',
                    'event_time' => time(),
                    'action_source' => 'website',
                    'event_id' => uniqid(),
                    'user_data' => $user_data,
                    'custom_data' => [
                        'currency' => 'EGP',
                        'value' => $order->total
                    ]
                ]
            ]
        ];

        // إرسال الحدث للـ Meta
        $response = Http::post("https://graph.facebook.com/v17.0/{$pixel_id}/events?access_token={$access_token}", $event_data);

        // تسجيل الرد في اللوج لمراجعة أي مشاكل
        Log::info('Meta CAPI Response', ['response' => $response->body()]);

        return $response->body();
    }


    
}
