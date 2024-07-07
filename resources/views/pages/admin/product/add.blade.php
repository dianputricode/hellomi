@extends('admin-main-layout')

@section('title', 'Tambah Produk')

@section('content')
    @auth
    <div class="content-container">
        <h1>Tambah Produk</h1>
        <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data" class="form-centered">
            @csrf
            <div class="form-group">
                <label for="product_image">Foto Produk</label>
                <input type="file" name="product_image" id="product_image" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="product_name">Nama Produk</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="price">Harga Produk</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="weight">Berat</label>
                <input type="text" name="weight" id="weight" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="dimensions">Dimensi</label>
                <input type="text" name="dimensions" id="dimensions" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="capacity">Kapasitas</label>
                <input type="text" name="capacity" id="capacity" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="material">Bahan</label>
                <input type="text" name="material" id="material" class="form-control" required>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <style>
        .content-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 120px 100px 100px 100px;
        }

        .form-centered {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 50%;
            margin-bottom: 15px;
        }

        .form-group label {
            margin-bottom: 5px;
            text-align: left;
            width: 100%;
        }

        .form-group input {
            padding: 8px;
            width: 100%;
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
        }

        .form-group button:hover {
            background-color: #333333;
        }
    </style>
@endsection
