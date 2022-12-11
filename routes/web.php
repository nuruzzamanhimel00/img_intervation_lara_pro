<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/add-image',[ImageController::class,'addImage'])->name('images.add');

    Route::post('/store-image',[ImageController::class,'storeImage'])->name('images.store');

    Route::get('/view-image',[ImageController::class,'viewImage'])->name('images.view');

    Route::get('/delete-image/{id}',[ImageController::class,'deleteImage'])->name('delete.image');
});



