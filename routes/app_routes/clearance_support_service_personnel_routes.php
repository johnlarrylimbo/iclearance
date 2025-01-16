<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearancePages\WireClearanceSupportServicePersonnel;

Route::prefix('ssp')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceSupportServicePersonnel::class)->lazy();
});
