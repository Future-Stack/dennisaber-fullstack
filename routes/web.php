<?php

use App\Http\Controllers\Admin\AuthController;
use Illuminate\Support\Facades\Route;

Route::view('/','frontend.pages.home')->name('home');

//Auth
Route::view('/login','frontend.pages.auth.login')->name('login');
Route::view('/register','frontend.pages.auth.register')->name('register');
Route::view('/forgot-password','frontend.pages.auth.forget-password')->name('forgot-password');

Route::view('/payment','frontend.pages.payment')->name('payment');
Route::view('/faster-processing','frontend.pages.faster-processing')->name('faster-processing');
Route::view('/copy-protection','frontend.pages.copy-protection')->name('copy-protection');
Route::view('/pages/privacy-policy','frontend.pages.privacy-policy')->name('privacy-policy');
Route::view('/pages/imprint','frontend.pages.imprint')->name('imprint');
Route::view('/pages/payment-participation','frontend.pages.payment-participation')->name('payment-participation');

//Course
Route::view('/course/advanced','frontend.pages.course.advanced')->name('course-advanced');
Route::view('/course/compact','frontend.pages.course.compact')->name('course-compact');
Route::view('/course/make-decision','frontend.pages.course.make-decision')->name('course-advanced');
Route::view('/course/nutrition','frontend.pages.course.nutrition')->name('course-nutrition');
Route::view('/course/premium','frontend.pages.course.premium')->name('course-premium');
Route::view('/course/press-public','frontend.pages.course.press-public')->name('course-press-public');
Route::view('/course/under-pressure','frontend.pages.course.rhetoric-under-pressure')->name('course-under-pressure');
Route::view('/course/rio-negro','frontend.pages.course.rio-negro')->name('rio-negro');
Route::view('/course/smoke-free','frontend.pages.course.smoke‑free')->name('smoke-free');
Route::view('/course/stress-resources','frontend.pages.course.stress-resources')->name('stress-resources');
Route::view('/course/successful‑startup','frontend.pages.course.successful‑startup')->name('successful‑startup');


//admin site
Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/login',[AuthController::class,'loginPage'])->name('login');
    Route::get('/forget-password',[AuthController::class,'forgetPage'])->name('forget-password');
    Route::post('/loginStore',[AuthController::class,'loginStore'])->name('loginStore');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');


    Route::view('/dashboard','admin.pages.dashboard')->name('dashboard');
});
