<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
})->name('index');

// Route::get('/bill', function () {
//     return view('bill');
// });

Route::get('/bill', [HomeController::class, 'index'])->name('bill');
Route::post('/submitBill', [HomeController::class, 'submitBill'])->name('submit-bill');
Route::get('/billItem/{id}', [HomeController::class, 'getItem'])->name('bill-item');
Route::get('/billList', [HomeController::class, 'listBill'])->name('bill-list');
Route::get('/billProfile/{id}', [HomeController::class, 'billProfile'])->name('bill-profile');
