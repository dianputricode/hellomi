@extends('main-layout')

@section('title', 'Hellomi Bags')

@section('content')
    <div class="container-banner" style="background-image: url('{{ asset('images/banner.png') }}'); margin-bottom: 150px">
        <div class="content-banner">
            <p class="product-selection">Pilih Berbagai Produk Tas</p>
            <p class="brand-name">HELLOMI BAGS</p>
            <p class="best-choice">Pilihan terbaik untuk tampil mempesona</p>
            <div class="btn">
                <a href="{{ url('/katalog') }}">Lihat Produk</a>
                <div class="arrow-right"></div>
            </div>
        </div>
        <div class="overlay-text">
            <div class="asset">
                <img src="{{ asset('images/handmade.png') }}" alt="Handmade">
                <p>Handmade</p>
            </div>
            <div class="asset">
                <img src="{{ asset('images/quality.png') }}" alt="Kualitas terbaik">
                <p>Kualitas Terbaik</p>
            </div>
            <div class="asset">
                <img src="{{ asset('images/price.png') }}" alt="Harga terjangkau">
                <p>Harga Terjangkau</p>
            </div>
        </div>
    </div>

    <div class="container-home">
        <div class="slogan">
            <p>Temukan Produk Terbaik Anda</p>
            <p style="font-weight: 1000; color: #4848A4;">HELLOMI BAGS</p>
        </div>
        <div class="product">
            <div class="product-grid">
                @forelse($products as $product)
                    @if ($loop->index < 3)
                        <div class="product-card">
                            <a href="{{ route('detail', ['id' => $product->id]) }}" class="image-container">
                                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
                                <div class="details-container" style="margin: 0; padding: 20px 20px 25px 20px">
                                    <p class="name" style="margin: 13px">{{ $product->product_name }}</p>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($product->averageRating >= $i)
                                                <i class="fas fa-star checked"></i>
                                            @else
                                                <i class="fas fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </a>
                            <div class="wishlist-rent">
                                @auth
                                    <button type="button" onclick="toggleWishlist({{ $product->id }})" style="color: {{ in_array($product->id, $wishlistIds) ? 'red' : '#333' }};">
                                        <i id="favorite-icon-{{ $product->id }}" class="material-icons" style="color: {{ in_array($product->id, $wishlistIds) ? 'red' : 'black' }};">
                                            @if (in_array($product->id, $wishlistIds))
                                                favorite
                                            @else
                                                favorite_border
                                            @endif
                                        </i>
                                    </button>
                                @else
                                    <button onclick="showLoginAlert()">
                                        <i class="material-icons" style="font-size: 30px; color: #333;">
                                            favorite_border
                                        </i>
                                    </button>
                                @endauth
                            </div>
                        </div>
                    @endif
                @empty
                    <p>Tidak ada produk.</p>
                @endforelse
            </div>
        </div>
        @if (!$products->isEmpty())
            <div onclick="navigateTo('{{ url('/catalogue') }}')" class="btn-view-all">
                <a href="{{ url('/catalogue') }}">Lihat Semua</a>
            </div>
        @endif
    </div>

    <script>
        function navigateTo(url) {
            window.location.href = url;
        }

        function showLoginAlert() {
            Swal.fire({
                title: 'Silakan Login',
                text: 'Anda perlu login terlebih dahulu untuk menambahkan ke wishlist.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }

        // Function to toggle wishlist
        function toggleWishlist(productId) {
            const icon = document.getElementById(`favorite-icon-${productId}`);
            const isFavorited = icon.innerText.trim() === 'favorite';

            // Toggle icon style and content
            icon.innerText = isFavorited ? 'favorite_border' : 'favorite';
            icon.style.color = isFavorited ? '#333' : 'red';

            // Send AJAX request to toggle wishlist in backend
            fetch(`{{ route('wishlist.toggle', ':id') }}`.replace(':id', productId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // For debugging purposes
                    if (data.success) {
                        const action = isFavorited ? 'dihapus dari' : 'ditambahkan ke';
                        Swal.fire({
                            position: 'bottom-end', // Menampilkan di pojok kanan bawah
                            icon: 'success',
                            title: `Berhasil ${action} wishlist.`,
                            toast: true,
                            showConfirmButton: false, // Tidak perlu tombol OK
                            timer: 1500 // Durasi tampilan alert (ms)
                        });
                    } else {
                        throw new Error('Gagal mengubah wishlist.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        position: 'bottom-end', // Menampilkan di pojok kanan bawah
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat mengubah wishlist.',
                        toast: true,
                        showConfirmButton: false, // Tidak perlu tombol OK
                        timer: 1500 // Durasi tampilan alert (ms)
                    });
                });
        }

    </script>

    <style>
        .product-card {
            text-align: center;
            position: relative;
            overflow: hidden;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .details-container {
            padding: 10px;
        }

        .name {
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        .image-container img {
            width: 100%;
            border-radius: 15px;
        }

        .wishlist-rent {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
    </style>
@endsection
