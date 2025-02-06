<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'loadHome']);
Route::get('/team', [DashboardController::class, 'showTeam']);
Route::get('/team/{teamId}', [DashboardController::class, 'showTeam']);