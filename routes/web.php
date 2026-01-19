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
// Route::get('/history', fn() => view('home'))->name('history.index');

Route::resource('cart', CartController::class)->except(['index'])->middleware('auth');

Route::resource('shop', ShopController::class)->only(['show']);

Volt::route('shop', 'shop-index')->name('shop.index');
Volt::route('history', 'history-index')->name('history.index');


Route::middleware(['auth', config('jetstream.auth_session'), 'verified'])
    ->group(
        function () {
            // Route::post('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
            Route::redirect('settings', 'settings/profile');

            // Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
            // Volt::route('settings/password', 'settings.password')->name('settings.password');
            // Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

            Volt::route('cart', 'cart')->name('cart.index');
            Volt::route('checkout', componentName: 'checkout')->name('checkout.index');
            Volt::route('payment/{slug}', componentName: 'payment')->name('payment.index');
            Volt::route('invoice/{slug}', componentName: 'payment')->name('invoice');

        }
    );

Route::middleware(['auth', config('jetstream.auth_session'), 'verified', 'admin'])->group(
    function () {
        Route::get('dashboard', App\Livewire\Dashboard::class)->name('dashboard');

        Route::resource('dashboard/products', ProductController::class);
        Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');
        Route::resource('/products', ProductController::class);
        Route::resource('/categories', CategoryController::class);
        Route::resource('/suppliers', SupplierController::class);
        Route::resource('/admin', UserController::class)->except(['edit', 'update']);

        Volt::route('coupon', 'coupon-index')->name('coupon.index');
        Volt::route('coupon/add', 'coupon-create')->name('coupon.create');
        Volt::route('coupon/{slug}/edit', 'coupon-create')->name('coupon.edit');

        Volt::route('settings/profile', 'profile')->name('settings.profile');
        Volt::route('settings/address', 'update-address')->name('settings.address');
        Volt::route('settings/password', 'update-password')->name('settings.password');
        Volt::route('settings/appearance', 'appearence')->name('settings.appearance');



        Volt::route('transaction', 'transaction-index')->name('transaction.index');
    }
);
