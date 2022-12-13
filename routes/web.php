<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\EmailVerifiyController;
use App\Http\Controllers\Auth\RessetPasswordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayPointController;
use App\Http\Controllers\PsychiatristController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SocialResearcherController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Mail\SendDataPayPointEmail;
use App\Mail\SendDetailsChargeEmail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware('Local')->group(function(){

    Route::middleware('guest')->group(function(){
        Route::get('/type-user',[AuthController::class , 'choiseGuard'])->name('auth.choise_guard');
        Route::get('/{guard}/login', [AuthController::class , 'loginPage'])->name('auth.login_page');
        Route::post('/login', [AuthController::class , 'login'])->name('auth.login');
        Route::get('/forgot',[RessetPasswordController::class , 'showForgot'])->name('auth.forgot');
        Route::post('/reset',[RessetPasswordController::class , 'sendLinkReset'])->name('auth.reset');
        Route::get('/reset-password/{token}',[RessetPasswordController::class , 'showResetPassword'])->name('password.reset');
        Route::post('/reset-password',[RessetPasswordController::class , 'resetPassword'])->name('auth.reset_password');
    });



    Route::middleware('auth:users,compony,employee')->group(function(){
        Route::get('/block',[AuthController::class , 'blockAccount'])->name('auth.block');
    });


    /// -------------------- Auth Routes -------------

    Route::middleware(['auth:users,compony,employee,point','Block'])->group(function(){
        // ----- Global  Route ---------
        Route::post('logout', [AuthController::class , 'logoutUser'])->name('auth.logout');
        Route::get('/',[HomeController::class , 'index'])->name('home.index');
        Route::post('/set-local',[HomeController::class , 'setLocal'])->name('set_local');
        Route::post('/change-password',[ChangePasswordController::class , 'changePassword'])->name('auth.change_password');


        Route::get('/notification',[HomeController::class , 'showNotification'])->name('notification');
        Route::post('/notification/read',[HomeController::class , 'readNotification'])->name('read_notification');
        
        // ----- PayPoints  Route ---------
        Route::get('pay_points/reports/{pay_point}',[PayPointController::class , 'showReport'])->name('pay_points.report');
        Route::resource('pay_points',PayPointController::class);

        // ----- Users  Route ---------
        Route::post('users/status/{user}',[UserController::class , 'changeStatus']);
        Route::get('users/reports/{user}',[UserController::class , 'showReport'])->name('users.report');
        Route::get('/users/{user}/permission/edit',[UserController::class , 'editUserPermission'])->name('users.permissions');
        Route::put('/users/{user}/permission/update',[UserController::class , 'updateUserPermission'])->name('users.update_permissions');
        Route::resource('users',UserController::class);

        // ----- Employees  Route ---------
        Route::post('employees/status/{employee}',[EmployeeController::class , 'changeStatus']);
        Route::get('employees/reports/{employee}',[EmployeeController::class , 'showReport'])->name('employees.report');
        Route::resource('employees',EmployeeController::class);

        // ----- City  Route ---------
        Route::resource('cities',CityController::class);

        // ----- Role Permission  Route ---------
        Route::put('/roles/{role}/giv-permission',[RolePermissionController::class , 'givPermissionRole']);
        Route::resource('roles',RolePermissionController::class);

        // ----- Category  Route ---------
        Route::post('categories/status/{category}',[CategoryController::class , 'changeStatus']);
        Route::resource('categories',CategoryController::class);

        // ----- Sub Category  Route ---------
        Route::post('sub_categories/status/{sub_category}',[SubCategoryController::class , 'changeStatus']);
        Route::get('sub_categories/reports/{sub_category}',[SubCategoryController::class , 'showReport'])->name('sub_categories.report');
        Route::resource('sub_categories',SubCategoryController::class);

        // ----- Charge Mony  Route ---------
        Route::post('/charge/user/info',[ChargeController::class , 'userInfo']);
        Route::post('/charge/send-code',[ChargeController::class , 'sendCodeVerificationCharge']);
        Route::resource('charge',ChargeController::class);

        // ----- Reports Route ---------
        Route::controller(ReportController::class)->group(function(){
            Route::get('report/paypoint','showPayPoint')->name('report.paypoint');
            Route::get('report/paypoint/{pay_points}','showReportPayPoint')->name('report.paypoint.show');
            Route::get('report/user','showUser')->name('report.user');
            Route::get('report/user/{user}','showReportUser')->name('report.user.show');
            Route::get('report/subcategory','showSubCategory')->name('report.subcategory');
            Route::get('report/subcategory/{sub_category}','showReportSubCategory')->name('report.subcategory.show');
        });


        


        
        



        

    });

    
});


