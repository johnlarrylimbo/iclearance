<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\IndividualEmployeeClearance\WireViewIndividualEmployeeClearance;

Route::prefix('view-individual-employee-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', WireViewIndividualEmployeeClearance::class)->name('employee.view_individual_clearance')->lazy();
});
