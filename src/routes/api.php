<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthCheckController;

Route::middleware(['owner', 'throttle:60,1'])->get('/v1/health-check', [HealthCheckController::class, 'index']);