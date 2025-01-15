<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearancePages\WireClearanceFacultyHed;

Route::prefix('hed')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceFacultyHed::class)->lazy();
});
