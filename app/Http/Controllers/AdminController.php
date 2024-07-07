<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rate;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function manageProduct()
    {
        $products = Product::all();
        return view('pages.admin.product.manage', compact('products'));
    }

    public function dashboard()
    {
        $wishlistCount = Wishlist::distinct('user_id')->count('user_id');

        $topProducts = Wishlist::select('product_id', DB::raw('count(*) as total'))
            ->groupBy('product_id')
            ->orderBy('total', 'desc')
            ->with('product')
            ->take(3)
            ->get();

        return view('pages.admin.dashboard', compact('wishlistCount', 'topProducts'));
    }

    public function viewWishlist(Request $request) {
        // Ambil semua wishlist
        $wishlists = Wishlist::with('user', 'product')->get();

        $products = Product::all();

        // Jika ada nama produk yang difilter
        if ($request->has('product_name') && $request->product_name != '') {
            $product = Product::where('product_name', $request->product_name)->first();
            $wishlists = Wishlist::where('product_id', $product->id)->with('user', 'product')->get();
        }

        // Ambil ringkasan produk jika ada nama produk yang dipilih
        $productSummary = [];
        if ($request->has('product_name') && $request->product_name != '') {
            $productSummary['product_name'] = $product->product_name;
            $productSummary['total_wishlists'] = $wishlists->count();
        }

        return view('pages.admin.view-wishlist', [
            'wishlists' => $wishlists,
            'products' => $products,
            'productSummary' => $productSummary,
        ]);
    }

    public function viewRating(Request $request)
    {
        // Ambil semua produk untuk dropdown filter
        $products = Product::orderBy('product_name', 'asc')->get();

        // Query awal untuk ratings
        $query = Rate::query();

        // Filter berdasarkan produk jika ada
        if ($request->has('product_id') && $request->product_id != '') {
            $query->where('product_id', $request->product_id);
        }

        // Sorting berdasarkan nama produk
        if ($request->has('sort_product')) {
            if ($request->sort_product == 'asc') {
                $query->join('products', 'rates.product_id', '=', 'products.id')
                    ->orderBy('products.product_name', 'asc');
            } elseif ($request->sort_product == 'desc') {
                $query->join('products', 'ratings.product_id', '=', 'products.id')
                    ->orderBy('products.product_name', 'desc');
            }
        }

        // Sorting berdasarkan rating
        if ($request->has('sort_rating')) {
            if ($request->sort_rating == 'asc') {
                $query->orderBy('rating', 'asc');
            } elseif ($request->sort_rating == 'desc') {
                $query->orderBy('rating', 'desc');
            }
        }

        // Ambil data ratings berdasarkan query yang sudah dibuat
        $ratings = $query->with(['user', 'product'])->get();

        // Jika ada filter produk yang dipilih, ambil juga ringkasan rating produk tersebut
        $selectedProductId = $request->product_id;
        $selectedProduct = null;
        $productRatings = collect([]);
        $totalRatings = 0;

        if ($selectedProductId) {
            $selectedProduct = Product::find($selectedProductId);
            $productRatings = Rate::where('product_id', $selectedProductId)->get();
        } else {
            $totalRatings = Rate::avg('rating');
        }

        return view('pages.admin.view-rating', [
            'ratings' => $ratings,
            'products' => $products,
            'selectedProductId' => $selectedProductId,
            'selectedProduct' => $selectedProduct,
            'productRatings' => $productRatings,
            'totalRatings' => $totalRatings,
        ]);
    }
}
