<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\ItemController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\OrderController;
use App\Http\Middleware\IsAdmin;
use App\Models\Category;

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

Auth::routes(['register' => false]);

Route::get('/', function () {
    return view('home.home');
})->middleware(['auth'])->name('home');


Route::middleware(['auth'])->prefix('panel')->name('panel.')->group(function (){    

    Route::middleware('isAdmin')->group(function (){
        //Routes for Categories
        Route::get('/categorias', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categorias/crear', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categorias', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categorias/{id}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/categorias/{id}/editar', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categorias/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categorias/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        //Routes for Items
        Route::get('/items', [ItemController::class, 'index'])->name('items.index');
        Route::get('/items/crear', [ItemController::class, 'create'])->name('items.create');
        Route::post('/items', [ItemController::class, 'store'])->name('items.store');
        Route::get('/items/{id}', [ItemController::class, 'show'])->name('items.show');
        Route::get('/items/{id}/editar', [ItemController::class, 'edit'])->name('items.edit');
        Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
        Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');    
    });
 
    //Routes for Orders
    Route::get('/ordenes', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/ordenes/crear', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/ordenes', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/ordenes/{id}', [OrderController::class, 'show'])->name('orders.show');
    // Route::put('/ordenes/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::put('/ordenes/{id}', [OrderController::class, 'addItem'])->name('orders.addItem');
    Route::delete('ordenes/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::delete('ordenes/{id}/{item_id}', [OrderController::class, 'destroyItem'])->name('orders.items.destroy');
    Route::put('/ordenes/{id}/cerrar', [OrderController::class, 'close'])->name('orders.close');
});