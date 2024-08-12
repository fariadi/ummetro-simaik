<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authentications\ApiController as AuthController;
use App\Http\Controllers\formulir\FormulirController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([
    'middleware' => 'api'
], function ($router) {
    
    /**
     * Authentication Module
     */
    Route::group(['prefix' => 'auth'], function() {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
    
    /**
     * Products Module
     */
    //Route::resource('products', ProductsController::class);
    //Route::get('products/view/all', [ProductsController::class, 'indexAll']);
    //Route::get('products/view/search', [ProductsController::class, 'search']);
});

Route::get('apl01/disetujui', [FormulirController::class,'filterApl01'])->middleware(['auth.sha1token']);
Route::get('mahasiswa/tagihan/{username}', [FormulirController::class,'inquiry'])->middleware(['auth.sha1token']);
Route::get('mahasiswa/payment/{username}', [FormulirController::class,'inquiry'])->middleware(['auth.sha1token']);
Route::get('mahasiswa/reversal/{username}', [FormulirController::class,'inquiry'])->middleware(['auth.sha1token']);


Route::post('tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    return ['token' => $token->plainTextToken];
});
Route::post('formulir/inquiry', [FormulirController::class,'inquiry'])->middleware(['payment']);
Route::post('formulir/payment', [FormulirController::class,'payment'])->middleware(['payment']);
Route::post('formulir/reversal', [FormulirController::class,'reversal'])->middleware(['payment']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
