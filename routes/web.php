<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Frontend\AuthController as CustomerAuthController;
use App\Http\Controllers\Frontend\CoursePlayerController;
use App\Http\Controllers\Frontend\CoursePreviewController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\MediaController;
use App\Http\Controllers\Frontend\MemberDashboardController;
use App\Http\Controllers\TimeTrackingController;
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
Route::view('/schnelle-abwicklung', 'frontend.pages.faster-processing')->name('schnelle-abwicklung');
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

Route::get('/kurse/{slug}', function ($slug) {
    $course = \App\Models\Course::where('slug', $slug)->first();
    if ($course) {
        return redirect($course->public_course_url);
    }
    abort(404);
});

/*
|--------------------------------------------------------------------------
| Course Previews (1:1 Proben Designs with Audios & PDFs)
|--------------------------------------------------------------------------
*/
Route::get('/akademie/bildungsurlaub', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'dnl-kompakt')->name('preview.compact');
Route::get('/akademie/vertiefung', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'dnl-vertiefung')->name('preview.advanced');
Route::get('/akademie/premium', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'dnl-premium')->name('preview.premium');

Route::get('/praevention/stress', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'stress-und-ressourcen')->name('preview.stress');
Route::get('/praevention/rauchfrei', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'rauchfrei')->name('preview.rauchfrei');
Route::get('/praevention/ernaehrung', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'ernaehrung')->name('preview.ernaehrung');
Route::get('/praevention/klar-entscheiden', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'klar-entscheiden')->name('preview.make-decision');

Route::get('/gruenden', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'erfolgreich-gruenden')->name('preview.gruenden');
Route::get('/presse', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'presse-oeffentlichkeit')->name('preview.presse');
Route::get('/rhetorik', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'rhetorik-unter-druck')->name('preview.rhetorik');
Route::get('/rausgehen-reicht-nicht/abenteuer', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'rio-negro-2002')->name('preview.abenteuer');
Route::get('/angebote', [CoursePreviewController::class, 'render'])->defaults('pageKey', 'angebote')->name('preview.angebote');

Route::get('/vorschau/{slug}', function ($slug) {
    return app(CoursePreviewController::class)->render($slug);
})->name('preview.slug');

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
    Route::post('/customers/{user}/reset-password', [AdminDashboardController::class, 'resetCustomerPassword'])->name('customers.reset-password');
    Route::post('/customers/{user}/assign-course', [AdminDashboardController::class, 'assignCustomerCourse'])->name('customers.assign-course');
    Route::delete('/customers/{user}', [AdminDashboardController::class, 'deleteCustomer'])->name('customers.delete');
    Route::post('/enrollments/{enrollment}/update', [AdminDashboardController::class, 'updateEnrollment'])->name('enrollments.update');
    Route::post('/enrollments/{enrollment}/toggle', [AdminDashboardController::class, 'toggleEnrollment'])->name('enrollments.toggle');
    Route::post('/enrollments/{enrollment}/immediate-start', [AdminDashboardController::class, 'immediateStartEnrollment'])->name('enrollments.immediate-start');

    // Staff Management
    Route::post('/staff', [AdminDashboardController::class, 'storeStaff'])->name('staff.store');
    Route::post('/staff/{user}/update', [AdminDashboardController::class, 'updateStaff'])->name('staff.update');
    Route::post('/staff/{user}/reset-password', [AdminDashboardController::class, 'resetStaffPassword'])->name('staff.reset-password');
    Route::post('/staff/{user}/toggle-active', [AdminDashboardController::class, 'toggleStaffActive'])->name('staff.toggle-active');
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
    Route::get('/time-tracking/overview', [TimeTrackingController::class, 'adminOverview'])->name('time-tracking.overview');
});

// Reference A Internal Links & Workspaces
Route::get('/mitarbeiter-login', [CustomerAuthController::class, 'loginPage'])->name('staff.login');
Route::get('/mitarbeiter', [MemberDashboardController::class, 'index'])->name('staff.workspace')->middleware('auth');
Route::get('/mitarbeiter-passwort', [CustomerAuthController::class, 'forgotPasswordPage'])->name('staff.forgot-password');
Route::get('/verwaltung/mitarbeiter-vorschau', [AdminDashboardController::class, 'staffPreview'])->name('verwaltung.staff-preview')->middleware(['auth', 'admin']);
Route::get('/verwaltung/audio-website', function () {
    return redirect()->route('service-rio-negro');
})->name('verwaltung.audio-website');
Route::get('/kurs-test', function () {
    return redirect()->route('course-compact');
})->name('kurs-test');
Route::get('/kurs-test/ernaehrung', function () {
    return redirect()->route('course-nutrition');
})->name('kurs-test.nutrition');
Route::get('/kurs-test/presse-oeffentlichkeit', function () {
    return redirect()->route('course-press-public');
})->name('kurs-test.press');

// Alias for /verwaltung pointing to admin dashboard
Route::middleware(['admin'])->prefix('verwaltung')->name('verwaltung.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| Internal Staff / Management Time Tracking & Abuse Report
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('api/time-tracking')->name('time-tracking.')->group(function () {
    Route::get('/status', [TimeTrackingController::class, 'status'])->name('status');
    Route::post('/start', [TimeTrackingController::class, 'start'])->name('start');
    Route::post('/pause', [TimeTrackingController::class, 'pause'])->name('pause.active');
    Route::post('/resume', [TimeTrackingController::class, 'resume'])->name('resume.active');
    Route::post('/stop', [TimeTrackingController::class, 'stop'])->name('stop.active');
    Route::post('/{timeEntry}/pause', [TimeTrackingController::class, 'pause'])->name('pause');
    Route::post('/{timeEntry}/resume', [TimeTrackingController::class, 'resume'])->name('resume');
    Route::post('/{timeEntry}/stop', [TimeTrackingController::class, 'stop'])->name('stop');
});
