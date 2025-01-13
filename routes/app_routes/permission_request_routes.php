<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\PermissionRequest\WirePermissionRequest;

Route::prefix('permission-request')->middleware(['auth'])->group(function() {
    Route::get('/', WirePermissionRequest::class)->lazy();
});
