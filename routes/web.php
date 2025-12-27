<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\QRController;
use App\Http\Middleware\CheckTableNumber;
use App\Livewire\Pages\AllFoodPage;
use App\Livewire\Pages\CartPage;
use App\Livewire\Pages\CheckoutPage;
use App\Livewire\Pages\DetailPage;
use App\Livewire\Pages\FavoritePage;
use App\Livewire\Pages\PromoPage;
use App\Livewire\Pages\HomePage;

use App\Livewire\Pages\PaymentFailurePage;
use App\Livewire\Pages\PaymentSuccessPage;
use App\Livewire\Pages\OrderTrackingPage;
use App\Livewire\Pages\KitchenDashboard;
use App\Livewire\Pages\ScanPage;
use Livewire\Livewire;

Route::middleware(CheckTableNumber::class)->group(function () {
    Route::get("/", HomePage::class)->name("home");

    Route::get("/food", AllFoodPage::class)->name("product.index");

    Route::get("/food/favorite", FavoritePage::class)->name("product.favorite");

    Route::get("/food/promo", PromoPage::class)->name("product.promo");

    Route::get("/food/{id}", DetailPage::class)->name("product.detail");
});

Route::middleware([CheckTableNumber::class, 'cart.expiry'])->controller(TransactionController::class)->group(function () {
    Route::get("/cart", CartPage::class)->name("payment.cart");
    Route::get("/checkout", CheckoutPage::class)->middleware('cart.verify')->name("payment.checkout");

    Route::middleware(["throttle:5,1", "cart.verify"])->post("/payment", "handlePayment")->name("payment");
    Route::get("/payment", function () {
        abort(404);
    });

    Route::get("/payment/status/{id}", "paymentStatus")->name("payment.status");
    Route::get("/payment/success", PaymentSuccessPage::class)->name("payment.success");
    Route::get("/payment/failure", PaymentFailurePage::class)->name("payment.failure");
});

Route::post("/payment/webhook", [TransactionController::class, "handleWebhook"])->name("payment.webhook");

// Export routes (Admin only - protected by Filament auth)
Route::prefix('export')->middleware('auth')->name('export.')->group(function () {
    Route::get('/transactions/pdf', [\App\Http\Controllers\ExportController::class, 'transactionsPdf'])->name('transactions.pdf');
    Route::get('/transactions/csv', [\App\Http\Controllers\ExportController::class, 'transactionsCsv'])->name('transactions.csv');
    Route::get('/best-sellers/pdf', [\App\Http\Controllers\ExportController::class, 'bestSellersPdf'])->name('best-sellers.pdf');
});

// Order Tracking (accessible without table number)
Route::get("/track-order/{invoice?}", OrderTrackingPage::class)->name("order.track");

// Kitchen Dashboard (PIN protected)
Route::middleware('kitchen.auth')->group(function () {
    Route::get("/kitchen", KitchenDashboard::class)->name("kitchen.dashboard");
});
Route::post("/kitchen/auth", function () {
    // Handled by middleware
    return redirect()->route('kitchen.dashboard');
})->name("kitchen.auth");

Route::controller(QRController::class)->group(function () {
    Route::post("/store-qr-result", "storeResult")->name("product.scan.store");
    Route::get("/qr/download/{id}", "download")->name("qr.download");

    Route::get("/scan", ScanPage::class)->name("product.scan");
    Route::get("/{tableNumber}", "checkCode")->name("product.scan.table");
});
