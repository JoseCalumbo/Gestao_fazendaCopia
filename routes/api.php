<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CooperativaController;
use App\Http\Controllers\TalhoesController;


Route::get('/cooperativas/{cooperativa}/estatisticas',
    [CooperativaController::class, 'estatisticas']
);