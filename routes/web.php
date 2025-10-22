<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\RegisterController; 
use App\Http\Controllers\Auth\LoginController;    
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WalletController; 

// Landing page (public)
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ===== Auth Routes =====
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');              

Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Semua route ini butuh login
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('wallets', WalletController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('transactions', TransactionController::class);

        // Budget 
        Route::resource('budgets', BudgetController::class)->only(['index','create','store','destroy']);

        Route::resource('goals', GoalController::class);

        // Reports
        Route::middleware(['auth'])->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/print', [ReportController::class, 'print'])->name('reports.print');
        Route::get('/reports/export-csv', [ReportController::class, 'exportCsv'])->name('reports.exportCsv');
    });
    
    // Goals contribute
    Route::post('/goals/{goal}/contribute', [GoalController::class,'contribute'])->name('goals.contribute');

    // Wallet transfer
    Route::post('wallets/transfer', [WalletController::class, 'transfer'])->name('wallets.transfer');

    // Purchase → langsung potong saldo
    Route::get('/purchase', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');

    Route::get('/profile', function () {
    return view('profile.index'); 
    })->name('profile.index');

    Route::get('/settings', function () {
    return view('settings.index'); // pastikan file ini ada
    })->name('settings.index');


});
