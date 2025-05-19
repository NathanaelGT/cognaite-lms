<?php

use App\Http\Middleware\CohortOnly;
use App\Livewire\Pay;
use Illuminate\Support\Facades\Route;

Route::get('/bayar/{transaction:snap_token}', Pay::class)->middleware(['auth', CohortOnly::class])->name('pay');
