<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceType\WireClearanceType;

Route::prefix('type')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceType::class)->lazy();
});
