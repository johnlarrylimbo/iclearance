<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\SendEmailForm;

Route::prefix('send-email')->middleware(['auth'])->group(function() {
    Route::get('/', SendEmailForm::class)->name('email.send-email')->lazy();
});
