<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Livewire\Products;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    $categories = Category::all();
    $products = Product::latest()->take(8)->get();
    return view('home', compact('categories', 'products'));
})->name('home');
// Route::get('/shop', fn() => view('home'))->name('shop');
Route::get('/about', fn() => view('home'))->name('about');
Route::get('/contact', fn() => view('contact'))->name('contact');
Route::get('/transaction', fn() => view('home'))->name('transaction.index');

Route::resource('cart', CartController::class)->middleware('auth');

Route::resource('shop', ShopController::class)->only(['index', 'show']);


Route::middleware(['auth', config('jetstream.auth_session'), 'verified'])
    ->group(
        function () {
            Route::post('checkout', [CheckoutController::class, 'index'])->name('chekout.index');
            Route::redirect('settings', 'settings/profile');

            Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
            Volt::route('settings/password', 'settings.password')->name('settings.password');
            Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

        }
    );

Route::middleware(['auth', config('jetstream.auth_session'), 'verified', 'admin'])->group(
    function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::resource('dashboard/products', ProductController::class);
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::resource('/products', ProductController::class);
        Route::resource('/categories', CategoryController::class);
        Route::resource('/suppliers', SupplierController::class);
        Route::resource('/admin', UserController::class)->except(['edit', 'update']);

        Volt::route('coupon', 'coupon-index')->name('coupon.index');
        Volt::route('coupon/add', 'coupon-create')->name('coupon.create');
        Volt::route('coupon/{slug}/edit', 'coupon-create')->name('coupon.edit');
    }
);
