<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class RateController extends Controller
{
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rate = new Rate();
        $rate->user_id = Auth::user()->id;
        $rate->product_id = $id;
        $rate->comment = $request->comment;
        $rate->rating = $request->rating;
        $rate->save();

        $product = Product::findOrFail($id);
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Komentar dan rating berhasil ditambahkan.',
            'rate' => $rate,
        ]);
    }

    public function getAverageRating($id)
    {
        try {
            $averageRating = Rate::where('product_id', $id)->avg('rating');
            return response()->json(['success' => true, 'average_rating' => $averageRating]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat mengambil rata-rata rating.'], 500);
        }
    }

}
