<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Response;

class WishlistController extends Controller
{
    public function toggleWishlist($productId)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return response()->json(['error' => 'Anda harus login untuk menambahkan ke wishlist.'], 403);
        }

        // Ambil user yang sedang login
        $user = Auth::user();

        // Validasi product_id
        if (!$productId) {
            return response()->json(['error' => 'ID produk tidak valid.'], 400);
        }

        // Cek apakah produk sudah ada di wishlist
        $wishlist = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            // Hapus produk dari wishlist
            $wishlist->delete();
            return response()->json(['success' => 'Produk dihapus dari wishlist.']);
        }

        // Tambahkan produk ke wishlist
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return response()->json(['success' => 'Produk ditambahkan ke wishlist.']);
    }
}
