<?php

use App\Http\Controllers\SmsModuleController;
use App\Models\SmsModule;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LogsGlobeSmsController;
use App\Http\Controllers\GlobeAppSettingController;

Route::get('/', function () {
    return Inertia::render('Home');
});
// Route::get('/setting', function () {
//     return Inertia::render('Setting');
// });

Route::get('/setting',[GlobeAppSettingController::class, 'index']);
Route::post('/setting/create',[GlobeAppSettingController::class, 'create']);

// Route::get('/sms-setting',[SmsModuleController::class, 'index']);

Route::post('/check-files', [LogsGlobeSmsController::class, 'checkFiles']);

Route::get('/logs', [LogController::class, 'index']);
