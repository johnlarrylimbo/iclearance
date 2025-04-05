<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\IndividualEmployeeClearance\WireIndividualEmployeeClearance;

Route::prefix('individual-employee-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', WireIndividualEmployeeClearance::class)->name('employee.individual_clearance')->lazy();
});
