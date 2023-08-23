<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\Contoh\TransaksiController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\DeleteController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/division/area', [DivisionController::class, 'getArea']);
Route::get('/area/equipment', [AreaController::class, 'getGe']);
Route::get('/equipment/type', [EquipmentController::class, 'getType']);

Route::get('/division/user', [DivisionController::class, 'index']);
Route::get('/area/user', [AreaController::class, 'index']);
Route::get('/equipment/user', [EquipmentController::class, 'index']);
Route::get('/type/user', [TypeController::class, 'index']);
Route::apiResource('/type', TypeController::class)->except(['store','delete','update']);

// Route::post('register', [RegisterController::class, 'register']);
// Route::get('register/confirmation/{id}', [RegisterController::class, 'confirmation']);
Route::post('login', [ApiAuthController::class, 'login']);

Route::get('/sample-news', SampleController::class);

Route::get('/division/getOption', [DivisionController::class, 'GetOptionsResource']);
Route::get('/area/getOption', [AreaController::class, 'GetOptionsResource']);
Route::get('/equipment/getOption', [EquipmentController::class, 'GetOptionsResource']);

Route::group(['middleware' => 'auth:api'], function () { // auth login di matiin dulu buat test
    Route::post('logout', [ApiAuthController::class, 'logout']);
    Route::get('cek-token', [ApiAuthController::class, 'cekValidToken']);
    Route::apiResource('/user', UserController::class);
    Route::group(['middleware' => 'superadminOnly'], function () { });
    //middleware bisa pakai cara ini
    //Route::apiResource('/user',UserController::class)->middleware('superadminOnly');
    Route::delete('/images/deleteimages/{id}', [DeleteController::class, 'DeleteImage']);
    Route::delete('/videos/deletevideos/{id}', [DeleteController::class, 'DeleteVideo']);




    Route::apiResource('/division', DivisionController::class);
    Route::apiResource('/area', AreaController::class);
    Route::apiResource('/equipment', EquipmentController::class);
    Route::apiResource('/type', TypeController::class)->only(['store','delete','update']);
    Route::post('/content/upload-image', [TypeController::class, 'contentImageUpload']);
    Route::post('/content/upload-video', [TypeController::class, 'contentVideoUpload']);

    //contoh transaksi master detail
    // Route::get('/transaksi/auto-number', [TransaksiController::class, 'generateNUmber']);
    // Route::apiResource('/transaksi', TransaksiController::class);
});
