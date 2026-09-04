<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Frontend\AuthController as CustomerAuthController;
use App\Http\Controllers\Frontend\CoursePlayerController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\MediaController;
use App\Http\Controllers\Frontend\MemberDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Landing Pages
|--------------------------------------------------------------------------
*/
Route::view('/', 'frontend.pages.home')->name('home');

Route::view('/payment', 'frontend.pages.payment')->name('payment');
Route::view('/zahlung', 'frontend.pages.payment')->name('zahlung');

Route::view('/faster-processing', 'frontend.pages.faster-processing')->name('faster-processing');
Route::view('/copy-protection', 'frontend.pages.copy-protection')->name('copy-protection');
Route::view('/kopierschutz', 'frontend.pages.copy-protection')->name('kopierschutz');

Route::view('/pages/privacy-policy', 'frontend.pages.privacy-policy')->name('privacy-policy');
Route::view('/datenschutz', 'frontend.pages.privacy-policy')->name('datenschutz');

Route::view('/pages/imprint', 'frontend.pages.imprint')->name('imprint');
Route::view('/impressum', 'frontend.pages.imprint')->name('impressum');

Route::view('/pages/payment-participation', 'frontend.pages.payment-participation')->name('payment-participation');
Route::view('/zahlungsbedingungen', 'frontend.pages.payment-participation')->name('zahlungsbedingungen');

// Legacy .html redirects to prevent 404s
Route::redirect('/zahlung.html', '/payment', 301);
Route::redirect('/payment.html', '/payment', 301);
Route::redirect('/kopierschutz.html', '/copy-protection', 301);
Route::redirect('/datenschutz.html', '/pages/privacy-policy', 301);
Route::redirect('/impressum.html', '/pages/imprint', 301);
Route::redirect('/zahlungsbedingungen.html', '/pages/payment-participation', 301);
Route::redirect('/login.html', '/login', 301);
Route::redirect('/passwort-vergessen.html', '/forgot-password', 301);
Route::get('/kurse/{slug}.html', function ($slug) {
    return redirect('/kurse/' . $slug, 301);
});

Route::post('/inquiry/mailto', [InquiryController::class, 'generateMailto'])->name('inquiry.mailto');

/*
|--------------------------------------------------------------------------
| Public Course Overview & Landing Pages
|--------------------------------------------------------------------------
*/
Route::view('/course/advanced', 'frontend.pages.course.advanced')->name('course-advanced');
Route::view('/kurse/dnl-vertiefung', 'frontend.pages.course.advanced');

Route::view('/course/compact', 'frontend.pages.course.compact')->name('course-compact');
Route::view('/kurse/dnl-kompakt', 'frontend.pages.course.compact');

Route::view('/course/make-decision', 'frontend.pages.course.make-decision')->name('course-make-decision');
Route::view('/kurse/klar-entscheiden', 'frontend.pages.course.make-decision');

Route::view('/course/nutrition', 'frontend.pages.course.nutrition')->name('course-nutrition');
Route::view('/kurse/ernaehrung', 'frontend.pages.course.nutrition');

Route::view('/course/premium', 'frontend.pages.course.premium')->name('course-premium');
Route::view('/kurse/dnl-premium', 'frontend.pages.course.premium');

Route::view('/course/press-public', 'frontend.pages.course.press-public')->name('course-press-public');
Route::view('/kurse/presse-oeffentlichkeit', 'frontend.pages.course.press-public');

Route::view('/course/under-pressure', 'frontend.pages.course.rhetoric-under-pressure')->name('course-under-pressure');
Route::view('/kurse/rhetorik-unter-druck', 'frontend.pages.course.rhetoric-under-pressure');

Route::view('/course/rio-negro', 'frontend.pages.course.rio-negro')->name('rio-negro');
Route::view('/kurse/rio-negro-2002', 'frontend.pages.course.rio-negro');
Route::view('/service/rio-negro', 'frontend.pages.course.rio-negro')->name('service-rio-negro');

Route::view('/course/smoke-free', 'frontend.pages.course.smoke-free')->name('smoke-free');
Route::view('/kurse/rauchfrei', 'frontend.pages.course.smoke-free');

Route::view('/course/stress-resources', 'frontend.pages.course.stress-resources')->name('stress-resources');
Route::view('/kurse/stress-und-ressourcen', 'frontend.pages.course.stress-resources');

Route::view('/course/successful-startup', 'frontend.pages.course.successful-startup')->name('successful-startup');
Route::view('/kurse/erfolgreich-gruenden', 'frontend.pages.course.successful-startup');
Route::view('/gruenden', 'frontend.pages.course.successful-startup')->name('gruenden');

/*
|--------------------------------------------------------------------------
| Customer / Member Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [CustomerAuthController::class, 'loginPage'])->name('login');
Route::get('/anmelden', [CustomerAuthController::class, 'loginPage'])->name('anmelden');
Route::post('/login', [CustomerAuthController::class, 'loginStore'])->name('login.store');

Route::get('/register', [CustomerAuthController::class, 'registerPage'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'registerStore'])->name('register.store');

Route::get('/forgot-password', [CustomerAuthController::class, 'forgotPasswordPage'])->name('forgot-password');
Route::get('/passwort-vergessen', [CustomerAuthController::class, 'forgotPasswordPage'])->name('passwort-vergessen');
Route::post('/forgot-password', [CustomerAuthController::class, 'forgotPasswordStore'])->name('forgot-password.store');
Route::post('/passwort-vergessen', [CustomerAuthController::class, 'forgotPasswordStore'])->name('passwort-vergessen.store');

Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Customer / Member Area & Course Player
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'member'])->group(function () {
    Route::get('/mitglieder', [MemberDashboardController::class, 'index'])->name('member.dashboard');
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

    // Course Player & Progress Tracking
    Route::get('/kurs/{slug}', [CoursePlayerController::class, 'showCourse'])->name('course.show');
    Route::get('/kurs/{courseSlug}/lektion/{lessonSlug}', [CoursePlayerController::class, 'showLesson'])->name('course.lesson');
    Route::post('/kurs/{courseSlug}/lektion/{lessonSlug}/toggle-complete', [CoursePlayerController::class, 'toggleComplete'])->name('course.lesson.toggle');

    // Protected Media Delivery
    Route::get('/media/course/{courseSlug}/lesson/{lessonSlug}/{type}', [MediaController::class, 'streamMedia'])->name('media.stream');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication & Management Routes
|--------------------------------------------------------------------------
*/
Route::get('/verwaltung/anmelden', [AdminAuthController::class, 'loginPage'])->name('verwaltung.login');
Route::get('/admin/login', [AdminAuthController::class, 'loginPage'])->name('admin.login');
Route::post('/admin/loginStore', [AdminAuthController::class, 'loginStore'])->name('admin.loginStore');
Route::get('/admin/forget-password', [AdminAuthController::class, 'forgetPage'])->name('admin.forget-password');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
Route::post('/verwaltung/abmelden', [AdminAuthController::class, 'logout'])->name('verwaltung.logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [AdminDashboardController::class, 'index']);

    // Customer Management
    Route::post('/customers', [AdminDashboardController::class, 'storeCustomer'])->name('customers.store');
    Route::post('/customers/{user}/toggle-active', [AdminDashboardController::class, 'toggleCustomerActive'])->name('customers.toggle');
    Route::post('/customers/{user}/reset-device', [AdminDashboardController::class, 'resetCustomerDevice'])->name('customers.reset-device');
    Route::delete('/customers/{user}', [AdminDashboardController::class, 'deleteCustomer'])->name('customers.delete');

    // Staff Management
    Route::post('/staff', [AdminDashboardController::class, 'storeStaff'])->name('staff.store');
    Route::delete('/staff/{user}', [AdminDashboardController::class, 'deleteStaff'])->name('staff.delete');

    // Personal Admin Notes (10-day auto-expiry)
    Route::post('/notes', [AdminDashboardController::class, 'storeAdminNote'])->name('notes.store');
    Route::delete('/notes/{note}', [AdminDashboardController::class, 'deleteAdminNote'])->name('notes.delete');

    // Next Version Pinboard
    Route::post('/version-notes', [AdminDashboardController::class, 'storeVersionNote'])->name('version-notes.store');
    Route::delete('/version-notes/{note}', [AdminDashboardController::class, 'deleteVersionNote'])->name('version-notes.delete');

    // Access Requests (Zugangsanfragen)
    Route::post('/access-requests/{accessRequest}/resolve', [AdminDashboardController::class, 'resolveAccessRequest'])->name('access-requests.resolve');
    Route::delete('/access-requests/{accessRequest}', [AdminDashboardController::class, 'deleteAccessRequest'])->name('access-requests.delete');

    // Course Management
    Route::post('/courses', [AdminDashboardController::class, 'storeCourse'])->name('courses.store');
    Route::post('/courses/{course}/update', [AdminDashboardController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminDashboardController::class, 'deleteCourse'])->name('courses.delete');

    // Lesson & Media Management
    Route::post('/courses/{course}/lessons', [AdminDashboardController::class, 'storeLesson'])->name('lessons.store');
    Route::post('/lessons/{lesson}/update', [AdminDashboardController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/lessons/{lesson}', [AdminDashboardController::class, 'deleteLesson'])->name('lessons.delete');

    // Admin Security Settings
    Route::post('/change-password', [AdminAuthController::class, 'changePassword'])->name('change-password');

    // Admin Time Tracking Overview
    Route::get('/time-tracking/overview', [\App\Http\Controllers\TimeTrackingController::class, 'adminOverview'])->name('time-tracking.overview');
});

// Alias for /verwaltung pointing to admin dashboard
Route::middleware(['auth', 'admin'])->prefix('verwaltung')->name('verwaltung.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Internal Staff / Management Time Tracking & Abuse Report
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('api/time-tracking')->name('time-tracking.')->group(function () {
    Route::get('/status', [\App\Http\Controllers\TimeTrackingController::class, 'status'])->name('status');
    Route::post('/start', [\App\Http\Controllers\TimeTrackingController::class, 'start'])->name('start');
    Route::post('/pause', [\App\Http\Controllers\TimeTrackingController::class, 'pause'])->name('pause.active');
    Route::post('/resume', [\App\Http\Controllers\TimeTrackingController::class, 'resume'])->name('resume.active');
    Route::post('/stop', [\App\Http\Controllers\TimeTrackingController::class, 'stop'])->name('stop.active');
    Route::post('/{timeEntry}/pause', [\App\Http\Controllers\TimeTrackingController::class, 'pause'])->name('pause');
    Route::post('/{timeEntry}/resume', [\App\Http\Controllers\TimeTrackingController::class, 'resume'])->name('resume');
    Route::post('/{timeEntry}/stop', [\App\Http\Controllers\TimeTrackingController::class, 'stop'])->name('stop');
});
