@extends('admin-main-layout')

@section('title', 'Admin Dashboard')

@section('content')
    @auth
    <div class="dashboard-container" style="margin-top: 7%;">
        <div class="welcome">
            <h1>Selamat Datang,</h1>
            <span class="username-dashboard">{{ ucfirst(strtok(Auth::user()->username, '@')) }}!</span>
        </div>
        <div class="dashboard">
            <div class="see-rating">
                <span class="see-judul">Lihat Rating</span>
                <span style="font-size: 15px">Lihat rating yang diberikan oleh pengguna untuk mendapatkan insight tentang kepuasan mereka terhadap produk. Dengan memahami feedback ini, Anda dapat mengidentifikasi area yang perlu diperbaiki dan meningkatkan kualitas layanan secara keseluruhan.</span>
                <div class="btn-rating">
                    <a href="{{ url('/view-ratings') }}">Lihat Rating</a>
                    <div class="arrow-right"></div>
                </div>
            </div>
            <div class="see-wishlist">
                <span class="see-judul">Lihat Wishlist</span>
                <span style="font-size: 15px">Lihat daftar wishlist pengguna dan produk-produk yang paling diminati. Fitur ini membantu Anda mengidentifikasi tren terbaru dan memahami preferensi pelanggan, sehingga Anda dapat menyusun strategi pemasaran yang lebih efektif dan tepat sasaran.</span>
                <div class="btn-wishlist">
                    <a href="{{ url('/view-wishlist') }}">Lihat Wishlist</a>
                    <div class="arrow-right"></div>
                </div>
            </div>
            <div class="manage-product">
                <span class="see-judul">Kelola Produk</span>
                <span style="font-size: 15px">Kelola daftar produk dengan mudah. Anda bisa menambah, mengedit, atau menghapus produk sesuai kebutuhan. Dengan pengelolaan yang baik, Anda memastikan bahwa informasi produk selalu up-to-date dan menarik bagi pelanggan.</span>
                <div class="btn-manage">
                    <a href="{{ url('/manage-products') }}">Kelola Produk</a>
                    <div class="arrow-right"></div>
                </div>
            </div>
        </div>
    </div>
    @else
        <script>
            window.location.replace("{{ route('login') }}");
        </script>
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data for wishlist count
            var wishlistCount = @json($wishlistCount);

            // Data for top products
            var topProducts = @json($topProducts);
            var topProductNames = topProducts.map(product => product.product.product_name);
            var topProductCounts = topProducts.map(product => product.total);

            // Wishlist Count Chart
            var ctx = document.getElementById('wishlistCountChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Wishlist Count'],
                    datasets: [{
                        label: 'Jumlah Orang yang Menambahkan ke Wishlist',
                        data: [wishlistCount],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)'],
                        borderColor: ['rgba(75, 192, 192, 1)'],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            var ctx2 = document.getElementById('topProductsChart').getContext('2d');
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: topProductNames,
                    datasets: [{
                        label: 'Top 3 Produk yang Paling Banyak Ditambahkan ke Wishlist',
                        data: topProductCounts,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    return topProducts[tooltipItem.dataIndex].product.product_name + ': ' + tooltipItem.raw;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
