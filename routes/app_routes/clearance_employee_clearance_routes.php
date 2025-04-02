<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\EmployeeClearance\WireEmployeeClearance;

Route::prefix('employee-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', WireEmployeeClearance::class)->name('employee.clearance')->lazy();
});
