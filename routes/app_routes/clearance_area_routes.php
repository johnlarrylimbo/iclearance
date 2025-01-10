<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceArea\ClearanceArea;

Route::prefix('area')->middleware(['auth'])->group(function() {
    Route::get('/', ClearanceArea::class)->lazy();
});
