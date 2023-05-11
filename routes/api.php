<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;

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

Route::post('signup', [AuthController::class, 'signup'])->name('page.signup');
Route::post('login', [ AuthController::class, 'login'])->name('login');
Route::post('reset-password-link', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);

//profile routes
Route::group(['prefix' => 'profile', 'middleware'=> 'auth:api'], function(){
    Route::get('data', [ProfileController::class, 'getProfileData'])->name('profile.get-data');
    Route::post('update', [ProfileController::class, 'updateProfile'])->name('profile.update');
});
