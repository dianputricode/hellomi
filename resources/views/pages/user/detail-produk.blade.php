@extends('main-layout')

@section('title', 'Detail Produk')

@section('content')
    <!-- Hero section -->
    <div class="container-detail-hero" style="background-image: url('{{ asset('images/banner.png') }}');">
        <div class="btn-back" onclick="backTo()">
            <div class="arrow-left"></div>
            Back
        </div>
        <div class="detail-hero">
            <p class="product-selection">Pilih Berbagai Produk Tas</p>
            <p class="brand-name">HELLOMI BAGS</p>
            <p class="best-choice">Pilihan terbaik untuk tampil mempesona</p>
        </div>
    </div>

    <!-- Product detail section -->
    <div class="detail-container">
        <div class="detail-foto">
            <img src="{{ asset($product->product_image) }}" alt="{{ $product->product_name }}">
        </div>

        <div class="detail-info">
            <div class="wish">
                <span class="nama-produk">{{ $product->product_name }}</span>
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
            <span class="harga-produk">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            @php
                $averageRating = $product->average_rating ?? 0;
            @endphp
            <div class="avg-rate">
                <label for="averageRating"></label>
                <div class="detail-rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $averageRating ? ' checked' : ' gray' }}"></i>
                    @endfor
                </div>
            </div>
            <hr>
            <p class="spek-product">Spesifikasi Produk</p>
            <div class="material">
                <span>Bahan</span>
                <span>:</span>
                <span>{{ $product->material }}</span>
            </div>
            <div class="dimensions">
                <span>Dimensi</span>
                <span>:</span>
                <span>{{ $product->dimensions }}</span>
            </div>
            <div class="capacity">
                <span>Kapasitas</span>
                <span>:</span>
                <span>{{ $product->capacity }}</span>
            </div>
            <div class="weight">
                <span>Berat</span>
                <span>:</span>
                <span>{{ $product->weight }}</span>
            </div>
        </div>
    </div>

    <div class="my-comment">
        <!-- Comments and ratings section -->
        <div class="my-comment-view">
            <div class="comment-view">
                <p style="font-weight: 600; font-size: 18px;">Lihat Komentar dan Rating</p>
                <hr>
                @if ($rates->isEmpty())
                    <p>Tidak ada penilaian untuk produk ini.</p>
                @else
                    @foreach ($rates as $key => $rate)
                        <div class="comment">
                            <div class="comment-header">
                                <img src="{{ $rate->user->profile_picture ? asset($rate->user->profile_picture) : asset('images/default.jpg') }}" alt="{{ $rate->user->username }}" class="user-avatar">
                                <span class="username">{{ $rate->user->username }}</span>
                                <div class="rating-stars-comment">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $rate->rating ? ' checked' : '' }}" style="font-size: 15px;"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="comment-body">
                                <span>{{ $rate->comment }}</span>
                            </div>
                        </div>
                        @if (!$loop->last)
                            <hr>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Add comment and rating section -->
        @auth
            <div class="my-comment-section">
                <div class="comment-section">
                    <p style="font-weight: 600; font-size: 18px;">Tambah Komentar dan Rating</p>
                    <hr>
                    <form id="commentForm" action="{{ route('product.comment', ['id' => $product->id]) }}" method="POST">
                        @csrf
                        <div class="add-comment" style="display: flex; flex-direction: column">
                            <label for="comment">Komentar</label>
                            <textarea style="font-family: 'Poppins', sans-serif" class="txt-comment" id="comment" name="comment" placeholder="Tulis komentar Anda di sini ..." rows="4" cols="50" required></textarea>
                        </div>
                        <div class="add-rating">
                            <label for="rating" style="padding-right: 25px">Rating</label>
                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" data-value="{{ $i }}"></i>
                                @endfor
                            </div>
                            <input type="hidden" id="rating" name="rating" value="0">
                        </div>
                        <button type="submit" style="font-family: 'Poppins', sans-serif" class="btn-send-comment">Kirim</button>
                    </form>
                </div>
            </div>
        @else
            <div class="my-comment-section">
                <div class="comment-section">
                    <p style="font-weight: 600; font-size: 18px;">Tambah Komentar dan Rating</p>
                    <hr>
                    <p>Silakan login untuk menambahkan komentar dan rating.</p>
                </div>
            </div>
        @endauth
    </div>

    <!-- Other content sections -->
    <div class="order">
        <div class="btn-view-all">
            <a href="#" onclick="showHowToOrder()">How to Order?</a>
        </div>
        <div class="order-wa">
            <span>Order via WhatsApp :</span>
            <a href="https://wa.me/6285643401228">
                <i class="fab fa-whatsapp" style="color: #2D2D51; font-size: 35px;"></i>
            </a>
        </div>
    </div>

    <!-- Scripts for functionality -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function backTo() {
            window.history.back();
        }

        function showHowToOrder() {
            Swal.fire({
                title: "Cara Order Hellomi Bags >.<",
                html: "1. Lihat produk di katalog kami<br>2. Order produk via chat Whatsapp yang sudah tersedia di website ini<br>3. Klik logo Whatsapp<br>4. Anda akan diarahkan ke Whatsapp dan dapat langsung memesan produk yang Anda inginkan"
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


        // AJAX form submission for seamless experience
        document.getElementById('commentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var form = this;
            var formData = new FormData(form);

            // Get selected rating or default to 0 if none is selected
            var rating = 0;
            const stars = document.querySelectorAll('.rating-stars .fa-star');
            stars.forEach(star => {
                if (star.classList.contains('checked')) {
                    rating = parseInt(star.getAttribute('data-value'));
                }
            });

            // Set rating value in form data
            formData.set('rating', rating);

            // Check if rating and comment are filled before submission
            const comment = formData.get('comment').trim();
            if (rating === 0 || comment === '') {
                Swal.fire({
                    title: 'Rating atau komentar belum diisi',
                    text: 'Anda harus memilih rating dan mengisi komentar untuk menambahkan ulasan.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    // Handle response
                    console.log(data);
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Komentar dan rating berhasil ditambahkan.'
                    }).then((result) => {
                        // Reload comments section or update dynamically
                        location.reload(); // Reload halaman untuk memperbarui komentar
                    });
                    form.reset();
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menambahkan komentar dan rating.'
                    });
                });
        });

        // Star rating functionality
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-stars .fa-star');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = parseInt(this.getAttribute('data-value'));

                    // Reset all stars to outline
                    stars.forEach(s => s.classList.remove('checked'));

                    // Add checked class to selected stars
                    for (let i = 0; i < value; i++) {
                        stars[i].classList.add('checked');
                    }

                    // Set rating value in hidden input (if needed)
                    document.getElementById('rating').value = value;
                });
            });
        });

        function showLoginAlert() {
            Swal.fire({
                title: 'Silakan Login',
                text: 'Anda perlu login terlebih dahulu untuk menambahkan ke wishlist.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        }
    </script>
@endsection
