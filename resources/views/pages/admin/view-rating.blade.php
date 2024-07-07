@extends('admin-main-layout')

@section('title', 'Ratings')

@section('content')
    <div class="container" style="margin-top: 7%;">
        <h1>Ratings</h1>

        @if ($ratings->isEmpty())
            <p>Tidak ada penilaian yang ditambahkan oleh pengguna.</p>
        @else
            <!-- Filter produk -->
            <form id="ratingFilterForm" action="{{ route('view.rating') }}" method="GET">
                <div class="filter-group">
                    <label for="product_id">Filter berdasarkan produk:</label>
                    <select name="product_id" id="product_id" class="form-select">
                        <option value="">Semua Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->product_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort_product">Urutkan berdasarkan nama produk:</label>
                    <select name="sort_product" id="sort_product" class="form-select">
                        <option value="asc" {{ request('sort_product') == 'asc' ? 'selected' : '' }}>A-Z</option>
                        <option value="desc" {{ request('sort_product') == 'desc' ? 'selected' : '' }}>Z-A</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort_rating">Urutkan berdasarkan rating:</label>
                    <select name="sort_rating" id="sort_rating" class="form-select">
                        <option value="asc" {{ request('sort_rating') == 'asc' ? 'selected' : '' }}>Terendah ke Tertinggi</option>
                        <option value="desc" {{ request('sort_rating') == 'desc' ? 'selected' : '' }}>Tertinggi ke Terendah</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" id="filterButton">Filter</button>
            </form>
            <table class="table" id="ratingsTable">
                <thead>
                <tr>
                    <th>Username</th>
                    <th>Nama Produk</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Waktu ditambahkan</th>
                </tr>
                </thead>
                <tbody>
                @foreach($ratings as $rating)
                    <tr>
                        <td>{{ $rating->user->username }}</td>
                        <td>{{ $rating->product->product_name }}</td>
                        <td>
                            @php
                                $ratingValue = $rating->rating;
                                $maxStars = 5;
                            @endphp

                            @if ($ratingValue > 0)
                                @for ($i = 1; $i <= $maxStars; $i++)
                                    @if ($i <= $ratingValue)
                                        <i class="fas fa-star checked"></i>
                                    @else
                                        <i class="fas fa-star"></i>
                                    @endif
                                @endfor
                            @else
                                Tidak ada penilaian
                            @endif
                        </td>
                        <td>{{ $rating->comment }}</td>
                        <td>{{ $rating->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Ringkasan rating -->
            <div class="rating-summary">
                <p><strong>
                        @if ($selectedProductId)
                            Ringkasan penilaian produk "{{ $selectedProduct->product_name }}":
                        @else
                            Ringkasan penilaian keseluruhan produk:
                        @endif
                    </strong></p>
                @if ($selectedProductId)
                    @if ($productRatings->isEmpty())
                        <p>Tidak ada penilaian untuk produk ini.</p>
                    @else
                        <p>Rata-rata penilaian: {{ number_format($productRatings->avg('rating'), 1) }} / 5 dari {{ $productRatings->count() }} pengguna</p>
                    @endif
                @else
                    <p>Rata-rata penilaian: {{ number_format($totalRatings, 1) }} / 5 dari semua pengguna</p>
                @endif
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-1p8r2GwmQ4rnPjCAWccsy6dRy3E+wahOgH33KdbE0bSh66jZOu+TMOQcHqyG5uFW3pIx2erM25Kq5yEvUkX9Dw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat ulang tabel ratings berdasarkan filter
            function reloadTable() {
                var formData = $('#ratingFilterForm').serialize();

                // Menggunakan AJAX untuk mengambil data ratings berdasarkan filter
                $.ajax({
                    url: '{{ route("view.rating") }}',
                    type: 'GET',
                    data: formData,
                    success: function(response) {
                        // Mengganti isi tabel ratings
                        var newHtml = $(response).find('#ratingsTable').html();
                        $('#ratingsTable').html(newHtml);

                        // Mengganti ringkasan penilaian
                        var summaryHtml = $(response).find('.rating-summary').html();
                        $('.rating-summary').html(summaryHtml);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }

            // Memuat ulang tabel saat form filter dikirim
            $('#ratingFilterForm').submit(function(e) {
                e.preventDefault(); // Hindari aksi bawaan dari form submit
                reloadTable();
            });

            // Memanggil reloadTable() untuk memuat tabel saat halaman pertama kali dimuat
            reloadTable();
        });
    </script>

    <style>
        select {
            font-family: 'Poppins', sans-serif;
        }

        #ratingFilterForm {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

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
