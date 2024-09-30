<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonsController;
use App\Http\Controllers\PhonesController;

// Ruta para restaurar una persona eliminada
Route::put('persons/{id}/restore', [PersonsController::class, 'restore'])->name('persons.restore');
Route::put('phones/{id}/restore', [PhonesController::class, 'restore'])->name('phones.restore');

Route::get('phones/create', [PhonesController::class, 'create'])->name('phones.create');
Route::get('/phones/{personId?}', [PhonesController::class, 'index'])->name('phones.index');


Route::get('/', function () {
    return view('welcome');
});

Route::resource('persons', PersonsController::class);
Route::resource('phones', PhonesController::class);