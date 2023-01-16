<?php

use Illuminate\Support\Facades\Route;
use Mail as Mail;

use App\User;

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

// Start of the VIEW ROUTES //

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('privacy-policy', function(){
    return view('privacy-policy');
});

// End of the VIEW ROUTES //

Auth::routes();

Route::get('/', function(){
    if (Auth::check()){
        if (Auth::User()->type == 'ALUMNI'){
            return redirect('dashboard');
        } else {
            return redirect('dashboard');
        }
    } else {
        return view('welcome');
    }

});

// register
Route::get('/register/confirm/{token}', [App\Http\Controllers\RegisterController::class, 'confirmEmail']);
Route::post('/register', [App\Http\Controllers\RegisterController::class, 'doRegister']);
Route::post('/login', [App\Http\Controllers\LoginController::class, 'doLogin']);

// Password reset link request routes...
Route::get('/login/reset', [App\Http\Controllers\PasswordResetController::class, 'showEmail']);
Route::post('/login/reset', [App\Http\Controllers\PasswordResetController::class, 'doEmail']);

// Password reset routes...
Route::get('/login/reset/token/{token}', [App\Http\Controllers\PasswordResetController::class, 'showReset']);
Route::post('/login/reset/token/{token}', [App\Http\Controllers\PasswordResetController::class, 'doReset']);

// SNS
Route::post('api/sns', [App\Http\Controllers\PublicPage::class, 'SaveSNSNotification']);

Route::group(['middleware' => 'auth.alumni'], function () {
    Route::get('/edit-profile', function () {
        return view('edit-profile');
    });
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout']);
    Route::post('/edit-profile', [App\Http\Controllers\editProfileController::class, 'updateInfo']);
    Route::post('/profilepicture', [App\Http\Controllers\editProfileController::class, 'uploadProfile']);
    Route::get('/dashboard/avatar', [App\Http\Controllers\dashboardController::class, 'getProfileImage']);
});