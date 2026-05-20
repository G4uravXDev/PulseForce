<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DietPlanController;
use App\Http\Controllers\TrainingProgramController;
use App\Http\Controllers\MerchandiseController;
use App\Http\Controllers\MemberController;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Firebase Google Login Callback
Route::post('/auth/firebase/callback', [\App\Http\Controllers\AuthController::class, 'firebaseCallback'])->name('auth.firebase.callback');

// Password Reset Routes
Route::get('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [\App\Http\Controllers\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [\App\Http\Controllers\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [\App\Http\Controllers\ForgotPasswordController::class, 'resetPassword'])->name('password.update');

Route::get('/features/training-programs', [TrainingProgramController::class, 'index'])->name('features.training-programs');
Route::get('/features/diet-plans', [DietPlanController::class, 'index'])->name('features.diet-plans');
Route::get('/features/merchandise', [MerchandiseController::class, 'index'])->name('features.merchandise');
Route::get('/features/progress-tracking', [LandingController::class, 'progressTracking'])->name('features.progress-tracking');
Route::get('/features/class-scheduling', [LandingController::class, 'classScheduling'])->name('features.class-scheduling');
Route::get('/features/memberships', [LandingController::class, 'memberships'])->name('features.memberships');

// Dashboard Route (requires auth)
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/admin/members', [\App\Http\Controllers\DashboardController::class, 'members'])->middleware('auth')->name('admin.members');
Route::post('/admin/members/{id}/toggle-block', [\App\Http\Controllers\DashboardController::class, 'toggleBlockMember'])->middleware('auth')->name('admin.members.toggleBlock');

// Profile Actions
Route::post('/profile/update', [\App\Http\Controllers\DashboardController::class, 'updateProfile'])->middleware('auth')->name('profile.update');

// Admin Actions
Route::get('/admin/report/download', [\App\Http\Controllers\DashboardController::class, 'downloadReport'])->middleware('auth')->name('admin.report.download');
Route::get('/admin/members/create', [\App\Http\Controllers\DashboardController::class, 'createMember'])->middleware('auth')->name('admin.members.create');
Route::post('/admin/members', [\App\Http\Controllers\DashboardController::class, 'storeMember'])->middleware('auth')->name('admin.members.store');
Route::post('/admin/members/{id}/update-plan', [\App\Http\Controllers\DashboardController::class, 'updateMemberPlan'])->middleware('auth')->name('admin.members.updatePlan');

Route::post('/admin/members/{id}/assign-workout', [\App\Http\Controllers\DashboardController::class, 'assignWorkout'])->middleware('auth')->name('admin.members.assignWorkout');
Route::post('/admin/members/{id}/assign-diet', [\App\Http\Controllers\DashboardController::class, 'assignDiet'])->middleware('auth')->name('admin.members.assignDiet');
Route::post('/admin/members/{id}/delete', [\App\Http\Controllers\DashboardController::class, 'deleteMember'])->middleware('auth')->name('admin.members.delete');
Route::post('/admin/members/{id}/activate', [\App\Http\Controllers\DashboardController::class, 'activateMember'])->middleware('auth')->name('admin.members.activate');

// Member Actions (AJAX)
Route::middleware('auth')->group(function () {
    Route::post('/member/toggle-exercise', [MemberController::class, 'toggleExercise'])->name('member.toggleExercise');
    Route::post('/member/toggle-meal', [MemberController::class, 'toggleMeal'])->name('member.toggleMeal');
    Route::post('/member/check-in', [MemberController::class, 'checkIn'])->name('member.checkIn');
});
