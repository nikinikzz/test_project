<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('profile');
// });
Route::get('/', [App\Http\Controllers\ProfileController::class, 'index'])->name('index');
Route::post('profile/store', [App\Http\Controllers\ProfileController::class, 'store'])->name('profile.store');
Route::get('profile/edit/{profile}', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::post('profile/edit/{profile}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
Route::delete('profile/destroy', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');


// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
