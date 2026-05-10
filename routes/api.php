<?php

use App\Http\Controllers\XenditCallbackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('xendit/callback', [XenditCallbackController::class, 'invoice'])->name('xendit.callback');
