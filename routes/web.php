<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Orders\Index as OrdersIndex;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', OrdersIndex::class);
