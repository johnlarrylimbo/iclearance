<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\AccessPermission\AccessPermission;

Route::prefix('request-access')->middleware(['auth'])->group(function() {
    Route::get('/', AccessPermission::class)->lazy();
});
