<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceEmployeeEnrollment\WireClearanceEmployeeEnrollment;

Route::prefix('employee-enrollment')->middleware(['auth'])->group(function() {
    Route::get('/', WireClearanceEmployeeEnrollment::class)->name('clearance.employee-enrollment')->lazy();
});
