@extends('main-layout')

@section('title', 'Profil')

@section('content')
    @auth
        <div class="profile">
            <p class="profil-hero">Selamat Datang</p>
            @php
                $profilePictureUrl = Auth::user()->profile_picture ? asset(Auth::user()->profile_picture) : asset('images/default.jpg');
            @endphp
            <img class="foto-profil" src="{{ $profilePictureUrl }}" alt="Foto Profil Pengguna">
        </div>
        <div class="profil-container">
            <div class="profile-judul">
                <span class="profil-user">{{ Auth::user()->username }}</span>
                <div class="profil-email">
                    <i class="fa fa-envelope" aria-hidden="true" style="color: #b3acac"></i>
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="btn-edit-profil">
                <a href="{{ url('/profil/edit') }}">Edit Profil</a>
            </div>
        </div>

        <div class="profil-wishlist">
            <p class="profil-wish-judul">Wishlist</p>
            @if ($wishlists->isEmpty())
                <p class="profil-wish-isi">Anda belum menambahkan produk ke wishlist.</p>
            @else
                <p class="profil-wish-isi">Wishlist Anda disimpan di sini</p>

                <div class="wishlist-container">
                    @foreach($wishlists as $wishlist)
                        <div class="wishlist-card" id="wishlist-item-{{ $wishlist->product->id }}">
                            <a href="{{ route('detail', ['id' => $wishlist->product->id]) }}">
                                <img class="product_image" src="{{ asset($wishlist->product->product_image) }}" alt="{{ $wishlist->product->product_name }}">
                            </a>
                            <a class="wishlist-product-name" href="{{ route('detail', ['id' => $wishlist->product->id]) }}">
                                <p>{{ $wishlist->product->product_name }}</p>
                            </a>
                            <p>Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</p>
                            <a href="https://wa.me/6285643401228?text=Saya tertarik dengan produk {{ urlencode($wishlist->product->product_name) }}. Mohon informasi lebih lanjut." target="_blank">
                                <i class="fab fa-whatsapp" style="color: #2D2D51; font-size: 30px;"></i>
                            </a>
                            <div class="wishlist-profile">
                                <form id="wishlistForm-{{ $wishlist->product->id }}" action="{{ route('wishlist.toggle', $wishlist->product->id) }}" method="post">
                                    @csrf
                                    @method('POST')
                                    <button type="button" onclick="toggleWishlist({{ $wishlist->product->id }})" style="color: {{ in_array($wishlist->product->id, $wishlists->pluck('product_id')->toArray()) ? '#333' : 'red' }};">
                                        <i id="favorite-icon-{{ $wishlist->product->id }}" class="material-icons" style="color: {{ in_array($wishlist->product->id, $wishlists->pluck('product_id')->toArray()) ? 'red' : 'black' }};">
                                            @if (in_array($wishlist->product->id, $wishlists->pluck('product_id')->toArray()))
                                                favorite
                                            @else
                                                favorite_border
                                            @endif
                                        </i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <script>
        // Function to toggle wishlist
        function toggleWishlist(productId) {
            const icon = document.getElementById(`favorite-icon-${productId}`);
            const currentColor = icon.style.color;
            const isFavorite = currentColor === 'red';

            fetch(`{{ route('wishlist.toggle', ':id') }}`.replace(':id', productId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Debugging purpose
                    if (data.success) {
                        icon.style.color = isFavorite ? '#333' : 'red';
                        const action = isFavorite ? 'dihapus dari' : 'ditambahkan ke';
                        Swal.fire({
                            position: 'bottom-end', // Display at bottom-right corner
                            icon: 'success',
                            title: `Berhasil ${action} wishlist.`,
                            toast: true,
                            showConfirmButton: false, // No need for OK button
                            timer: 1500 // Display duration (ms)
                        });

                        // Remove wishlist item from DOM if deleted
                        if (!isFavorite) {
                            const wishlistItem = document.getElementById(`wishlist-item-${productId}`);
                            if (wishlistItem) {
                                wishlistItem.remove();
                            }
                        }
                    } else {
                        console.error('Gagal mengubah wishlist.');
                        Swal.fire({
                            position: 'bottom-end', // Display at bottom-right corner
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan saat mengubah wishlist.',
                            toast: true,
                            showConfirmButton: false, // No need for OK button
                            timer: 1500 // Display duration (ms)
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        position: 'bottom-end', // Display at bottom-right corner
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan saat menghubungi server.',
                        toast: true,
                        showConfirmButton: false, // No need for OK button
                        timer: 1500 // Display duration (ms)
                    });
                });
        }
    </script>

    <style>
        .product_image {
            margin-top: 5px;
        }
        .wishlist-product-name:hover {
            text-decoration: underline;
        }
    </style>
@endsection
