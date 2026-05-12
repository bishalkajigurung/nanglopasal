<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ProductVarient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'varient_id' => 'required|exists:product_varients,id',
            'qty'        => 'required|integer|min:1|max:99'
        ]);

        $variant = ProductVarient::with('product.seller')->findOrFail($request->varient_id);
        $product = $variant->product;
        $seller  = $product->seller;
        $user    = Auth::guard('web')->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first');
        }

        $amount = $variant->price - ($variant->price * ($product->discount ?? 0) / 100);

        // Check if item already exists in cart
        $cart = Cart::where('user_id', $user->id)
            ->where('product_varient_id', $variant->id)
            ->first();

        if ($cart) {
            $cart->qty += $request->qty;
            $cart->amount = $amount;
            $cart->save();
        } else {
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->seller_id = $seller->id;
            $cart->product_id = $product->id;
            $cart->product_varient_id = $variant->id;
            $cart->qty = $request->qty;
            $cart->amount = $amount;
            $cart->save();
        }

        toast('Product added to cart successfully', 'success');
        return redirect()->back();
    }

    public function index()
    {
        $carts = Cart::with(['product', 'productVarient', 'seller'])
            ->where('user_id', Auth::guard('web')->user()->id)
            ->get();

        return view('frontend.carts', compact('carts'));
    }

    public function delete($id)
    {
        $cart = Cart::where('user_id', Auth::guard('web')->user()->id)
            ->where('id', $id)
            ->firstOrFail();
        $cart->delete();

        toast('Item removed from cart', 'success');
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:99'
        ]);

        $cart = Cart::where('user_id', Auth::guard('web')->user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $cart->qty = $request->qty;
        $cart->save();

        toast('Cart updated successfully', 'success');
        return redirect()->back();
    }

    
}
