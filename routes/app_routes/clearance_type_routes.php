<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\ClearanceType\ClearanceType;

Route::prefix('type')->middleware(['auth'])->group(function() {
    Route::get('/', ClearanceType::class)->lazy();
});
