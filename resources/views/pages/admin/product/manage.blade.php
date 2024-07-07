@extends('admin-main-layout')

@section('title', 'Kelola Produk')

@section('content')
    @auth
    <div class="container">
        <div class="header-container" style="margin-top: 7%;">
            <h1>Kelola Produk</h1>
            <a href="{{ route('product.create') }}" class="btn btn-success custom-btn">Tambah Produk</a>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>Foto Produk</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Bahan</th>
                <th>Berat</th>
                <th>Kapasitas</th>
                <th>Dimensi</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>
                        <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}" width="100">
                    </td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->material }}</td>
                    <td>{{ $product->weight }}</td>
                    <td>{{ $product->capacity }}</td>
                    <td>{{ $product->dimensions }}</td>
                    <td>
                        <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary custom-btn">Edit</a>
                        <form action="{{ route('product.destroy', $product->id) }}" method="POST" class="delete-form" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button style="font-family: Poppins" type="submit" class="btn btn-danger custom-btn delete-btn">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            position: relative;
        }

        .header-container h1 {
            margin: 0;
        }

        .header-container .custom-btn {
            margin-left: auto;
        }

        .custom-btn {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            line-height: 20px;
        }

        .btn-success.custom-btn {
            padding: 10px;
            background-color: #4848A4;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-family: Poppins, sans-serif;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-success.custom-btn:hover {
            background-color: #333333;
        }

        .btn-primary.custom-btn {
            background-color: #007bff;
            border: none;
            color: #333;
            text-decoration: none;
        }

        .btn-primary.custom-btn:hover {
            background-color: #0056b3;
        }

        .btn-danger.custom-btn {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger.custom-btn:hover {
            background-color: #c82333;
        }

        .table img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table td, .table th {
            vertical-align: middle;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-form').forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    var formElement = this;

                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data ini tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formElement.submit();
                        }
                    });
                });
            });

            @if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
            @endif
        });
    </script>
@endsection
