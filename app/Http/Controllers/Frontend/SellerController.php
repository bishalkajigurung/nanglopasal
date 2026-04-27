<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function seller_request(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:sellers",
            "shop_name" => "required",
            "contact" => "required|unique:sellers",
        ]);

        $seller = new Seller();
        $seller->name = $request->name;
        $seller->email = $request->email;
        $seller->shop_name = $request->shop_name;
        $seller->contact = $request->contact;
        $seller->save();

        return redirect()->back();
    }
}
