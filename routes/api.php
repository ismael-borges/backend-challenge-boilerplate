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
//    return view('formulario');

    DB::table('payment_projections')->select(['id', 'name', 'email'])
        ->where(['send_notification' => 0])
        ->orderBy('id')
        ->limit(10)
        ->chunk(5, static function($items) {
            dd($items);
            collect($items)->each(static function ($row) {
                dd($row);
            });
        });
});

Route::post('upload-file', [PaymentProjectionController::class, 'upload'])->name('upload-file');
