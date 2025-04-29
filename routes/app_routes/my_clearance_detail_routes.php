<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\MyClearance\WireMyClearanceDetail;

Route::prefix('my-clearance-detail')->middleware(['auth'])->group(function() {
    Route::get('/', WireMyClearanceDetail::class)->name('my.clearance-detail')->lazy();
});
