<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileControler;
use App\Http\Controllers\Auth\ProfileEducationController;
use App\Http\Controllers\Auth\ProfileFinancialInformationController;
use App\Http\Controllers\Auth\ProfileMetasController;
use App\Http\Controllers\Auth\ProfileMobileNumbersController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;

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
    'prefix' => 'v1',
], function ($router) {
    //general
    // Route::post('register', [RegisterController::class, 'register']);
    Route::post('request-otp', [LoginController::class, 'requestOTP']);
    Route::post('verify-otp', [LoginController::class, 'verifyOTP'])->name('login-for-otp');

    Route::get('qr', [LoginController::class, 'requstQrCode']);
    Route::get('qr/{id}/{hash}', [LoginController::class, 'qrRender'])->name('qr-render');

    //check login session
    Route::get('session-check/{type}/{id}/{hash}', [LoginController::class, 'sessionCheck']);

    //data
    Route::get('data/jobs', [DataController::class, 'jobs']);

    //private
    Route::group([
        'middleware' => 'jwt.auth',
        'prefix' => 'user',
    ], function ($router) {
        Route::get('modal', [LoginController::class, 'requestModalLogin']);
        Route::get('qr/{id}/{hash}', [LoginController::class, 'loginWithQrSession'])->name('login-with-qr');
        Route::get('modal/{id}/{hash}', [LoginController::class, 'loginWithModalSession'])->name('login-with-modal');

        // financial information
        Route::get('profile/financial-information', [ProfileFinancialInformationController::class, 'index']);
        Route::put('profile/financial-information', [ProfileFinancialInformationController::class, 'update']);

        // educational information
        Route::get('profile/education', [ProfileEducationController::class, 'index']);
        Route::put('profile/education', [ProfileEducationController::class, 'update']);

        // profile
        Route::get('profile', [ProfileControler::class, 'me']);
        Route::get('profile/{id}', [ProfileControler::class, 'single']);
        Route::put('profile', [ProfileControler::class, 'update']);

        // numbers
        Route::get('profile/mobile-numbers', [ProfileMobileNumbersController::class, 'index']);
        Route::post('profile/mobile-numbers', [ProfileMobileNumbersController::class, 'store']);

        // metas
        Route::get('profile/metas', [ProfileMetasController::class, 'index']);
        Route::put('profile/metas', [ProfileMetasController::class, 'store']);

        Route::post('check-username', [ProfileControler::class, 'checkUserName']);
        Route::post('set-username', [ProfileControler::class, 'setUserName']);
    });
});

Route::group([
				 'prefix' => 'trusted',
			 ], function ($router) {
	Route::post('get-user', [\App\Http\Controllers\Auth\TrustedRoutesController::class, 'getUser']);
});