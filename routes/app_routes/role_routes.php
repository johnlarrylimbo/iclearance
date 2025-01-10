<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\Roles\Roles;

Route::prefix('roles')->middleware(['auth'])->group(function() {
    Route::get('/', Roles::class)->lazy();
});
