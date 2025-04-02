<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceManagement\WireClearanceManagement;

Route::prefix('clearance-management')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceManagement::class)->lazy();
});
