<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Clearance\WireClearance;

Route::prefix('manage-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearance::class)->lazy();
});
