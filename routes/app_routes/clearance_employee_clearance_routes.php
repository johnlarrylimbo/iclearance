<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceDetail\WireClearanceDetail;

Route::prefix('employee-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceDetail::class)->name('employee.clearance')->lazy();
});
