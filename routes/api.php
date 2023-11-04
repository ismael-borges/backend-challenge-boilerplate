<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ScheduleImportController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/import-file', function() {
//    $content = new stdClass();
//    $content->id = 295;
//    $content->name = "Ismael Borges";
//    $content->debtDueDate = "04/11/2023";
//    $content->debtAmount = "1815.36";
//    return view('mails.notification_invoice', compact('content'));
    return view('formulario');
});

Route::post('upload-file', [ScheduleImportController::class, 'upload'])->name('upload-file');
