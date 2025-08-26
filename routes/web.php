<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->middleware(['auth']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('wallets', WalletController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('budgets', BudgetController::class);
    Route::resource('bills', BillController::class);
    Route::resource('goals', GoalController::class);
    Route::resource('vendors', VendorController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'exportCsv'])->name('reports.export');
    Route::post('/goals/{goal}/contribute', [GoalController::class,'contribute'])->name('goals.contribute');
    Route::post('wallets/transfer', [WalletController::class, 'transfer'])->name('wallets.transfer');


    // Fitur: Beli barang → langsung potong saldo
    Route::get('/purchase', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
});

require __DIR__ . '/auth.php';
