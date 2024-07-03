<?php

use App\Livewire\CartPage;
use App\Livewire\HomePage;
use App\Livewire\CancelPage;
use App\Livewire\AccountPage;
use App\Livewire\AccountsPage;
use App\Livewire\SuccessPage;
use App\Livewire\CheckoutPage;
use App\Livewire\MyOrdersPage;
use App\Livewire\ProductsPage;
use App\Livewire\Auth\LoginPage;
use App\Livewire\CategoriesPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\MyOrderDetailPage;
use App\Livewire\ProductDetailPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\ResetPasswordPage;
use App\Livewire\Auth\ForgotPasswordPage;
use App\Livewire\ChangePassword;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomePage::class);
Route::get('/categories', CategoriesPage::class);
Route::get('/products', ProductsPage::class);
Route::get('/products/{slug}', ProductDetailPage::class);

Route::get('/cart', CartPage::class);


Route::middleware('guest')->group(function (){
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class);
    Route::get('/reset/{token}', ResetPasswordPage::class)->name('password.reset');
    Route::get('/forgot', ForgotPasswordPage::class)->name('password.request');

});


Route::middleware('auth')->group(function (){
    Route::get('/logout', function () {
        auth()->logout();
        return redirect('/');
    });
    Route::get('/my-orders', MyOrdersPage::class);
    Route::get('/my-orders/{order_id}', MyOrderDetailPage::class)->name('my-orders.show');
    Route::get('/checkout', CheckoutPage::class);
    Route::get('/my-account', AccountsPage::class)->name('my-account');
    Route::get('/success', SuccessPage::class)->name('success');
    Route::get('/cancel', CancelPage::class)->name('cancel');
    Route::get('/payment/success', [CheckoutPage::class, 'success'])->name('payment.success');
});

Route::post('/midtrans/callback', [CheckoutPage::class, 'handleMidtransCallback'])->name('payment.callback');
Route::get('/midtrans/afterpayment', [CheckoutPage::class, 'afterPayment'])->name('after.payment');
