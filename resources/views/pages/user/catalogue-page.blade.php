@extends('main-layout')

@section('title', 'Katalog')

@section('content')
    <div class="container-banner" style="background-image: url('{{ asset('images/banner.png') }}');">
        <div class="content-banner">
            <p class="product-selection">Pilih Berbagai Produk Tas</p>
            <p class="brand-name">HELLOMI BAGS</p>
            <p class="best-choice">Pilihan terbaik untuk tampil mempesona</p>
        </div>
    </div>

    <div class="container-home">
        <div class="slogan">
            <p>Temukan Produk Terbaik Anda</p>
            <p style="font-weight: 1000; color: #4848A4;">HELLOMI BAGS</p>
        </div>

        <div class="product">
            <div class="cat-product-grid">
                @if ($products->isEmpty())
                    <div class="alert alert-info mt-3">Tidak ada produk tersedia saat ini.</div>
                @else
                    @foreach($products as $product)
                        <a href="{{ route('detail', ['id' => $product->id]) }}" class="product-card">
                            <div class="image-container">
                                <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
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
                            <div class="details-container">
                                <span class="name-cat">{{ $product->product_name }}</span>
                                <span style="font-weight: 600; padding-bottom: 8px">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <div class="rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($product->average_rating)
                                            <i class="fas fa-star{{ $i <= $product->average_rating ? ' checked' : '' }}" ></i>
                                        @else
                                            <span class="fa fa-star"></span>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-center mt-5 mb-0">
            {{ $products->links() }}
        </div>

        <div class="btn-view-all">
            <a href="#" onclick="showHowToOrder()">Bagaimana cara memesan produk?</a>
        </div>
    </div>

    <!-- SweetAlert2 for user interaction -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function navigateTo(url) {
            window.location.href = url;
        }

        function showHowToOrder() {
            Swal.fire({
                title: "Cara Memesan Produk Hellomi Bags >.<",
                html: "1. Lihat produk di katalog kami<br>2. Order produk via chat Whatsapp yang sudah tersedia di website ini<br>3. Klik logo Whatsapp<br>4. Anda akan diarahkan ke Whatsapp dan dapat langsung memesan produk yang Anda inginkan"
            });
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
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        span {
            text-decoration: none;
            color: #333;
        }

    </style>
@endsection
