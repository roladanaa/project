<?php

use App\Http\Controllers\Api\ArticalController;
use App\Http\Controllers\Api\Auth\AuthForgotPasswordController;
use App\Http\Controllers\Api\Auth\AuthLoginController;
use App\Http\Controllers\Api\Auth\AuthRegisterUserController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ChildrenController;
use App\Http\Controllers\Api\FatherController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\QsController;
use App\Http\Controllers\Api\SemesterController;
use App\Http\Controllers\Api\UserController;
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


Route::middleware('Local')->group(function(){

    Route::middleware('guest')->prefix('v1')->group(function(){
        Route::post('/auth/register', [AuthRegisterUserController::class , 'register']);
        Route::post('/auth/login', [AuthLoginController::class , 'login']);
        Route::post('/auth/send-code', [AuthForgotPasswordController::class , 'sendEmailCode']);
        Route::post('/auth/check-code', [AuthForgotPasswordController::class , 'checkCode']);
        Route::post('/auth/reset', [AuthForgotPasswordController::class , 'resetPassword']);

    });
    
    
    /// ------- Auth Route
    Route::middleware('auth:users')->prefix('v1')->group(function(){

        Route::post('auth/logout',[AuthLoginController::class , 'logout']);
        Route::post('auth/verified-check',[AuthLoginController::class , 'verifiedCheck']);
        Route::post('auth/verified-send',[AuthLoginController::class , 'sendEmailCodeVerified']);
        
        

        Route::controller(UserController::class)->group(function(){
            Route::post('users/wallet/create','createWalletUser');
            Route::post('users/transfers','sendMonyToUser');
            Route::post('users/transfers/subcategory/{sub_category}','sendMonyToCategory');
            Route::get('users/history/pay','historyPay');
            Route::get('users/history/charge','historyCharge');
            

        });

        Route::controller(CategoryController::class)->group(function(){
           
            Route::get('categories/all','allCategory');
            Route::get('categories/{category}','singleCategory');
            Route::get('categories/subcategory/{sub_category}','subCategory');

        });

        
       
    });

});

