<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Produtos
Route::get('/produtos', [ProductController::class, 'index'])->name('products.index');
Route::get('/produtos/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Carrinho
Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
Route::post('/carrinho/adicionar', [CartController::class, 'add'])->name('cart.add');
Route::patch('/carrinho/{item}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/carrinho/{item}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/carrinho', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/sucesso', [CheckoutController::class, 'success'])->name('checkout.success');

// Pedidos
Route::middleware('auth')->group(function () {
    Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// Perfil
Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/perfil/enderecos', [ProfileController::class, 'storeAddress'])->name('profile.addresses.store');
    Route::delete('/perfil/enderecos/{address}', [ProfileController::class, 'destroyAddress'])->name('profile.addresses.destroy');
});

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/entrar', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/entrar', [LoginController::class, 'login']);
    Route::get('/cadastrar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/cadastrar', [RegisterController::class, 'register']);
    Route::get('/esqueci-senha', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/esqueci-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/redefinir-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/redefinir-senha', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/sair', [LoginController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('produtos', AdminProductController::class);
    Route::resource('categorias', AdminCategoryController::class);

    Route::get('pedidos', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('pedidos/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('pedidos/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('pedidos/{order}/pagamento', [AdminOrderController::class, 'updatePayment'])->name('orders.update-payment');
});
