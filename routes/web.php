<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;

// Главная страница
Route::get('/', function () {
    return redirect()->route('cards.index');
});


Route::get('/cards/trash', [CardController::class, 'trash'])
    ->name('cards.trash');


Route::post('/cards/{card}/restore', [CardController::class, 'restore'])
    ->name('cards.restore');

Route::delete('/cards/{card}/force-delete', [CardController::class, 'forceDelete'])
    ->name('cards.forceDelete');


Route::resource('cards', CardController::class);