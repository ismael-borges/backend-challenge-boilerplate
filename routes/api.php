<?php

use App\Mail\SendNotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\PaymentProjectionController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/import-file', function() {
    return view('formulario');
});

Route::post('upload-file', [PaymentProjectionController::class, 'upload'])->name('upload-file');
