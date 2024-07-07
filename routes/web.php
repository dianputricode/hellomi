<?php

use App\Http\Controllers\RateController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogueController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Wishlist toggle for home page
Route::get('/katalog', [CatalogueController::class, 'index'])->name('catalogue');
Route::get('/tentang-hellomi', [AboutController::class, 'index'])->name('about');

Route::get('/profil', [ProfileController::class, 'index'])->name('profile');

// Wishlist toggle for profile page
Route::post('/profil/perbarui', [ProfileController::class, 'update'])->name('profile.update');

Route::get('/detail/{id}', [DetailController::class, 'index'])->name('detail');

Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout');

Route::get('/daftar', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('/daftar', [AuthController::class, 'register'])->name('register.post');

// Menyimpan perubahan pada profil pengguna
Route::put('/profil/perbarui', [ProfileController::class, 'update'])->name('profile.update');

// Menampilkan form edit profil
Route::get('/profil/edit', [ProfileController::class, 'edit'])->name('profile.edit');

// Menyimpan perubahan dari form edit profil
Route::post('/profil/edit/simpan', [ProfileController::class, 'saveEditedProfile'])->name('profile.saveEdited');

// Routes for managing products
Route::get('/kelola-produk', [AdminController::class, 'manageProduct'])->name('manage-products');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('/wishlists', [AdminController::class, 'viewWishlist'])->name('view.wishlist');
Route::get('/ratings', [AdminController::class, 'viewRating'])->name('view.rating');
Route::get('/produk/tambah-produk', [ProductController::class, 'create'])->name('product.create');
Route::post('/produk/tambah-produk', [ProductController::class, 'store'])->name('product.store');
Route::get('/produk/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/produk/{product}', [ProductController::class, 'update'])->name('product.update');
Route::delete('/produk/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/wishlist/toggle/{product_id}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');

// Route untuk menambahkan komentar dan rating pada produk
Route::post('produk/{id}/tambah-komentar', [RateController::class, 'comment'])->name('product.comment');

Route::POST('/email/verify', [UserController::class, 'sendEmailVerification'])->name('verification.send');
// Example route for email verification
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');

