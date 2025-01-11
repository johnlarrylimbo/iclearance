<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Clearance\Clearance;

Route::prefix('manage-clearance')->middleware(['auth'])->group(function() {
    Route::get('/', Clearance::class)->lazy();
});
