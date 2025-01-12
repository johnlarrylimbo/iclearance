<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Pages\PermissionRequest\PermissionRequest;

Route::prefix('permission-request')->middleware(['auth'])->group(function() {
    Route::get('/', PermissionRequest::class)->lazy();
});
