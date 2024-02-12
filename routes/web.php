<?php

use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [InfoController::class, 'index'])->name('index');
Route::get('/create', [InfoController::class, 'create'])->name('create');
Route::post('/store', [InfoController::class, 'store'])->name('store');
