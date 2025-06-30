<?php

use App\Http\Controllers\Api\GuestController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [GuestController::class, 'store']);
Route::get('/review', [GuestController::class, 'review']);
Route::post('/change-task', [GuestController::class, 'changeTask']);
