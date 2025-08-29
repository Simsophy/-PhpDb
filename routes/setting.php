<?php
use Illuminate\Support\Facades\Route;
Route::controller("CategoryController")->group(function(){
    Route::get('category', "index")->name('category.index');
    Route::get('category/create', "create")->name('category.create');
    Route::post('category/save', 
    "save")->name('category.save');
    Route::get('category/delete/{id}', "delete")->name('category.delete');
    Route::get('category/edit/{id}', "edit")->name('category.edit');
    Route::post('category/{id}', "update")->name('category.update');

});
