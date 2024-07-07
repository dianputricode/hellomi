<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $wishlistIds = [];

        if (Auth::check()) {
            $wishlistIds = Auth::user()->wishlist()->pluck('product_id')->toArray();
        }

        return view('pages.user.home', compact('products', 'wishlistIds'));
    }
}

