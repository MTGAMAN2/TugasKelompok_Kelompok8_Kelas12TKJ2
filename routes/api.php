<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChartDataController;

Route::middleware('auth:sanctum')->get('/chart/summary', [ChartDataController::class, 'summary']);
