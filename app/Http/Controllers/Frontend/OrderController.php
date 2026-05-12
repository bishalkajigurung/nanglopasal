<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function checkout($id)
    {
        $seller = Seller::findOrFail($id);
        $user = Auth::guard('web')->user();
        $carts = Cart::where("user_id", $user->id)->where("seller_id", $id)->get();

        return view('frontend.checkout', compact('seller', 'carts'));
    }

    public function checkoutStore(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
    $user = Auth::guard('web')->user();
    $carts = Cart::where("user_id", $user->id)
                 ->where("seller_id", $id)
                 ->get();

    $total = $carts->sum(fn($c) => $c->amount * $c->qty);

    // Update or create delivery address...
    if (!$user->delivery_address) {
        $delivery_address = new DeliveryAddress();
        $delivery_address->user_id = $user->id;
        $delivery_address->contact = $request->contact;
        $delivery_address->address_detail = $request->address_detail;
        $delivery_address->save();
    } else {
        $delivery_address = $user->delivery_address;
        $delivery_address->contact = $request->contact;
        $delivery_address->address_detail = $request->address_detail;
        $delivery_address->save();
    }

    $order = new Order();
    $order->user_id = $user->id;
    $order->seller_id = $seller->id;
    $order->total_amount = $total;           // ← Changed from 'total'
    $order->payment_method = $request->payment_method;
    $order->save();

    foreach ($carts as $cart) {
        $orderItem = new OrderItem();
        $orderItem->order_id = $order->id;
        $orderItem->product_id = $cart->product_id;
        $orderItem->product_varient_id = $cart->product_varient_id;
        $orderItem->qty = $cart->qty;
        $orderItem->amount = $cart->amount;
        $orderItem->save();

        $cart->delete();
    }

            if ($request->payment_method == 'cod') {
                toast('Order placed successfully!', 'success');
                return redirect()->route('carts');
            }

            $response = Http::withHeaders([
                "Authorization"=> "key ". $seller->khalti_secret_key
            ])->post("https://dev.khalti.com/api/v2/epayment/initiate/", [
                "return_url" => route('khalti.callback', $order->id),
                "website_url" => route('home'),
                "amount" => $total * 100,
                "purchase_order_id" => $order->id,
                "purchase_order_name" => $order->id,
            ]);

            return redirect($response["payment_url"]);
    }

    public function khalti_callback(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = $request["status"];
        $order->save();


        $message = "order " . $request["status"] . " successfully";
        toast($message, 'success');
        return redirect()->route('carts');
    }

}
