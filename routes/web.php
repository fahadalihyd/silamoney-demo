<?php

use App\Http\Controllers\SilaUserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use phpDocumentor\Reflection\Types\Resource_;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mig' , function ()
{
//    Artisan::call('migrate:fresh');
   Artisan::call('migrate');
});
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/request-kyc/{user}' , [\App\Http\Controllers\WalletController::class , 'kyc_req'])->name('request.kyc');
Route::get('/check-kyc/{user}' , [\App\Http\Controllers\WalletController::class , 'check_kyc'])->name('check.kyc');
Route::post('/wallet-register/{user}' , [\App\Http\Controllers\WalletController::class , 'register'])->name('register.wallet');
Route::post('/issue-sila/{user}' , [\App\Http\Controllers\WalletController::class , 'issue'])->name('issue.sila');
Route::post('/transfer-sila/{user}' , [\App\Http\Controllers\WalletController::class , 'transfer'])->name('transfer.sila');
Route::post('/redeem-sila/{user}' , [\App\Http\Controllers\WalletController::class , 'redeem'])->name('redeem.sila');
Route::post('/create-account/{user}' , [\App\Http\Controllers\WalletController::class , 'createAccount'])->name('create.account');

Route::get('/sila-user/transactions/{user}' , [SilaUserController::class , 'transactions'])->name('sila-user.transactions');
Route::resource('sila-user', SilaUserController::class);