<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.admin.dashboard', compact('products'));
    }

    public function create()
    {
        return view('pages.admin.product.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'material' => 'required|string',
            'weight' => 'nullable|string',
            'capacity' => 'nullable|string',
            'dimensions' => 'nullable|string',
        ]);

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/product_images'), $imageName);
        }

        $product = new Product();
        $product->product_image = 'storage/product_images/' . $imageName;
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->material = $request->input('material');
        $product->weight = $request->input('weight');
        $product->capacity = $request->input('capacity');
        $product->dimensions = $request->input('dimensions');
        $product->save();

        return redirect()->back()->with('success', 'Product added successfully.');
    }


    public function edit(Product $product)
    {
        return view('pages.admin.product.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'material' => 'required|string',
            'weight' => 'nullable|string',
            'capacity' => 'nullable|string',
            'dimensions' => 'nullable|string',
            'stock' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('product_image')) {
            // Hapus gambar lama jika ada dan simpan yang baru
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            $imagePath = $request->file('product_image')->store('produk_images', 'public');
        } else {
            // Jika tidak ada file gambar baru, gunakan gambar yang ada
            $imagePath = $product->product_image;
        }

        // Update data produk
        $product->update([
            'product_image' => $imagePath,
            'product_name' => $request->product_name,
            'price' => $request->price,
            'material' => $request->material,
            'weight' => $request->weight,
            'capacity' => $request->capacity,
            'dimensions' => $request->dimensions,
            'stock' => $request->stock,
        ]);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Hapus gambar produk jika ada dan hapus produk dari database
        if ($product->product_image) {
            Storage::disk('public')->delete($product->product_image);
        }
        $product->delete();
        return redirect()->route('manage-products')->with('success', 'Produk berhasil dihapus.');
    }

    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            $product = Product::findOrFail($id);
            $comment = new Comment();
            $comment->product_id = $product->id;
            $comment->user_id = auth()->user()->id;
            $comment->comment = $request->input('comment');
            $comment->rating = $request->input('rating');
            $comment->save();

            $averageRating = Comment::where('product_id', $product->id)->avg('rating');
            $product->average_rating = $averageRating;
            $product->save();

            return response()->json(['success' => true, 'message' => 'Komentar dan rating berhasil ditambahkan.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menambahkan komentar dan rating.'], 500);
        }
    }
}
