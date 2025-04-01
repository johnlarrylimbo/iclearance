<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceMonitoring\WireClearanceMonitoring;

Route::prefix('clearance-management')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceMonitoring::class)->lazy();
});
