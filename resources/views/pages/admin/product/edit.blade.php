@extends('main-layout')

@section('title', 'Edit Produk')

@section('content')
    @auth
    <div class="edit-product-container">
        <h2>Edit Produk</h2>
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input id="product_name" type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input id="price" type="number" name="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="form-group">
                <label for="material">Bahan</label>
                <input id="material" type="text" name="material" value="{{ old('material', $product->material) }}" required>
            </div>

            <div class="form-group">
                <label for="weight">Berat</label>
                <input id="weight" type="text" name="weight" value="{{ old('weight', $product->weight) }}">
            </div>

            <div class="form-group">
                <label for="capacity">Kapasitas</label>
                <input id="capacity" type="text" name="capacity" value="{{ old('capacity', $product->capacity) }}">
            </div>

            <div class="form-group">
                <label for="dimensions">Dimensi</label>
                <input id="dimensions" type="text" name="dimensions" value="{{ old('dimensions', $product->dimensions) }}">
            </div>

            <div class="form-group">
                <label for="product_image">Foto Produk</label>
                <input id="product_image" type="file" name="product_image">
                @if($product->product_image)
                    <div class="current-image">
                        <p>Foto produk sekarang:</p>
                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" width="200">
                    </div>
                @endif
            </div>

            <div class="form-group">
                <button type="submit">Update Product</button>
            </div>
        </form>
    </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <style>
        .edit-product-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 120px 100px 100px 100px;
        }

        .edit-product-container h2 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
            width: 100%;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4848A4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: Poppins, sans-serif;
            font-weight: 500;
            margin-top: 20px;
        }

        .form-group button:hover {
            background-color: #333333;
        }

        .current-image {
            margin-top: 10px;
        }

        .current-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection
