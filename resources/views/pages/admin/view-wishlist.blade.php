@extends('admin-main-layout')

@section('title', 'Wishlist')

@section('content')
    @auth
        <div class="container" style="margin-top: 7%;">
            <h1>Wishlist</h1>

            @if ($wishlists->isEmpty())
                <p>Tidak ada wishlist yang ditambahkan oleh pengguna saat ini.</p>
            @else
                <form id="ratingFilterForm" action="{{ route('view.wishlist') }}" method="GET">
                    @if (!$products->isEmpty())
                        <div class="filter-group" style="margin-bottom: 7px">
                            <label for="product_name">Filter berdasarkan nama produk:</label>
                            <select name="product_name" id="product_name" class="form-select">
                                <option value="">Semua Produk</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->product_name }}">{{ $product->product_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2" id="filterButton">Filter</button>
                    @endif
                </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Bahan</th>
                        <th>Berat</th>
                        <th>Kapasitas</th>
                        <th>Dimensi</th>
                        <th>Waktu Ditambahkan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($wishlists as $wishlist)
                        <tr>
                            <td>{{ $wishlist->user->username }}</td>
                            <td>{{ $wishlist->product->product_name }}</td>
                            <td>{{ $wishlist->product->price }}</td>
                            <td>{{ $wishlist->product->material }}</td>
                            <td>{{ $wishlist->product->weight }}</td>
                            <td>{{ $wishlist->product->capacity }}</td>
                            <td>{{ $wishlist->product->dimensions }}</td>
                            <td>{{ $wishlist->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!-- Ringkasan produk -->
                @if (!empty($productSummary))
                    <div class="product-summary">
                        <p><strong>Ringkasan produk "{{ $productSummary['product_name'] }}":</strong></p>
                        <p>Total wishlist: {{ $productSummary['total_wishlists'] }}</p>
                    </div>
                @endif
            @endif

            <!-- Total produk wishlist keseluruhan jika tidak ada filter -->
            @if ($products->isEmpty())
                <div class="total-wishlist">
                    <p><strong>Total produk wishlist keseluruhan:</strong> {{ $wishlists->count() }}</p>
                </div>
            @endif
        </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat ulang tabel wishlist berdasarkan filter
            function reloadTable() {
                var productName = $('#product_name').val();

                // Menggunakan AJAX untuk mengambil data wishlist berdasarkan filter
                $.ajax({
                    url: '{{ route("view.wishlist") }}',
                    type: 'GET',
                    data: {
                        product_name: productName
                    },
                    success: function(response) {
                        // Mengganti isi tabel wishlist
                        var newHtml = $(response).find('.table').html();
                        $('.table').html(newHtml);

                        // Mengganti ringkasan produk jika ada
                        var summaryHtml = $(response).find('.product-summary').html();
                        $('.product-summary').html(summaryHtml);

                        // Mengganti total produk wishlist keseluruhan jika tidak ada filter
                        var totalHtml = $(response).find('.total-wishlist').html();
                        $('.total-wishlist').html(totalHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Memuat ulang tabel saat tombol filter diklik
            $('#filterButton').click(function() {
                reloadTable();
            });

            // Memanggil reloadTable() untuk memuat tabel saat halaman pertama kali dimuat
            reloadTable();
        });
    </script>

    <style>
        #filterButton {
            width: 10%;
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

        #filterButton:hover {
            background-color: #333333;
        }
    </style>
@endsection
