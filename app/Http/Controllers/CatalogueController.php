<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        $wishlistIds = [];

        if (Auth::check()) {
            // If user is logged in, fetch wishlist product IDs
            $wishlistIds = Auth::user()->wishlist()->pluck('product_id')->toArray();
        }

        return view('pages.user.catalogue-page', compact('products', 'wishlistIds'));
    }
}
