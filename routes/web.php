<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CardController::class, 'index'])->name('home');

Route::resource('cards', CardController::class);

Route::patch('cards/{id}/restore', [CardController::class, 'restore'])
    ->name('cards.restore');

Route::delete('cards/{id}/force-delete', [CardController::class, 'forceDelete'])
    ->name('cards.forceDelete');
