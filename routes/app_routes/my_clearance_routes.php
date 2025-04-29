<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\MyClearance\WireMyClearance;

Route::prefix('my-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', WireMyClearance::class)->name('my.clearance')->lazy();
});
