<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Roles\WireRoles;

Route::prefix('roles')->middleware(['auth'])->group(function() {
    Route::get('/', WireRoles::class)->lazy();
});
