<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $products = Product::where('stock', true)->limit(8)->get();
        return view('frontend.home', compact('products'));
    }

   public function product($id)
    {
        $product = Product::find($id);
        return view('frontend.product', compact('product'));
    }

    //search products
    public function products(Request $request)
    {
        $q = $request->q;
        if ($q) {
            $products = Product::where('name', 'like', '%' . $q . '%')->where('stock', true)->get();
        } else {
            $products = Product::where('stock', true)->get();
        }
        return view('frontend.products', compact('products'));
    }

}
