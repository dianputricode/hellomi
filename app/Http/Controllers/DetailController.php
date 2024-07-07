<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rate;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index($id)
    {
        $product = Product::findOrFail($id);
        $rates = Rate::where('product_id', $product->id)->get();

        if (Auth::check()) {
            $wishlistIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        } else {
            $wishlistIds = [];
        }

        return view('pages.user.detail-produk', compact('product', 'rates', 'wishlistIds'));
    }
}

