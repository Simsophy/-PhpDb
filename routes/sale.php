<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sales\CustomerController;

Route::group(['middleware' => ['auth','trans']], function() {

    // Resource routes except show
    Route::resource('customer', CustomerController::class)->except(['show','destroy']);
  Route::post('customer/save', [CustomerController::class, 'save'])->name('customer.save');
    // Custom delete (if you don’t want to use resource destroy)
    Route::get('customer/delete/{id}', [CustomerController::class, 'delete'])->name('customer.delete');

});
