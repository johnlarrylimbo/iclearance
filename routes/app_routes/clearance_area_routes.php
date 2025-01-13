<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceArea\WireClearanceArea;

Route::prefix('area')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceArea::class)->lazy();
});
