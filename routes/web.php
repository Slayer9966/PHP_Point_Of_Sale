<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('index');
});

Route::Post('/store', [App\Http\Controllers\ProductsController::class, 'store'])->name('store');
Route::get('/edit1/{id}', [App\Http\Controllers\ProductsController::class, 'edit1'])->name('edit1');
Route::get('/edit2/{id}', [App\Http\Controllers\Auth\AdminController::class, 'edit2'])->name('edit2');
Route::get('/delete/{id}', [App\Http\Controllers\ProductsController::class, 'destroy'])->name('delete');
Route::Post('/update',[App\Http\Controllers\ProductsController::class,'update'])->name('update');
Route::Post('/updateUser',[App\Http\Controllers\Auth\AdminController::class,'update'])->name('updateuser');



Route::post('/', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');
Route::get('/bill',[App\Http\Controllers\BillController::class, 'bill'])->name('bill');
Route::get('/show', [App\Http\Controllers\HomeController::class, 'show'])->name('show');
Route::Post('/Add', [App\Http\Controllers\BillController::class, 'addToBill'])->name('Add');
Route::Post('/showBill', [App\Http\Controllers\BillController::class, 'showBill'])->name('showBill');
Route::get('deleteb/{id}', [App\Http\Controllers\BillController::class, 'deleteBill'])->name('deleteBill');
Route::post('/UpdateBill', [App\Http\Controllers\BillController::class, 'UpdateBill'])->name('UpdateBill');
Route::get('/Sell', [App\Http\Controllers\BillController::class, 'sell'])->name('Sell');
Route::get('/St', [App\Http\Controllers\BillController::class, 'testPdfGeneration'])->name('test');
Route::get('/ShowSold', [App\Http\Controllers\SoldController::class, 'show'])->name('ShowSold');
Route::get('/product/detail/{id}', [App\Http\Controllers\ProductsController::class, 'Detail'])->name('detail');
Route::get('/getUpdatedBill', [App\Http\Controllers\BillController::class, 'getUpdatedBill'])->name('getUpdatedBill');
// routes/web.php
Route::get('/getTotalQuantity/{productId}',[App\Http\Controllers\ProductsController::class,'getTotalQuantity'])->name('getTotalQuantity');
Route::post('/InputQuantity', [App\Http\Controllers\BillController::class, 'updateQuantity'])->name('UpdateQ');
Route::get('barcode',[App\Http\Controllers\ProductsController::class,'Barcode'])->name('barcode');
Route::get('deleteuser/{id}', [App\Http\Controllers\Auth\AdminController::class, 'destroy'])->name('deleteuser');
Route::get('Login/{id}', [App\Http\Controllers\Auth\AdminController::class, 'UserLogin'])->name('loginuser');

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin) {
        $users=User::get();
       
        return view('superadmin',['users'=>$users]);
    } else {
        return view('cashier');
    }
   
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('adduser',[App\Http\Controllers\Auth\AdminController::class,'create'])->name('addcashier');
    Route::post('adduser',[App\Http\Controllers\Auth\AdminController::class,'store']);


});

require __DIR__.'/auth.php';
