<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorksheetController;

Route::get('/', [PagesController::class, 'index'])->name('show.index');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::post('/login', 'login')->name('login');
    Route::get('/login', 'showLogin')->name('show.login');
    Route::post('/register', 'register')->name('register');
    Route::get('/register', 'showRegister')->name('show.register');
});

Route::middleware(['auth', 'can:admin'])->controller(PagesController::class)->group(function () {
    Route::get('/admin', 'admin')->name('show.admin');
    Route::delete('/admin', 'delete')->name('admin.delete');
});

Route::middleware('auth')->controller(WorksheetController::class)->group(function () {
    Route::post('/editor', 'create')->name('show.editor');
    Route::post('/editor/save', 'saveWorksheet')->name('editor.save');
    Route::get('/editor/generatePDF', 'generatePDF')->name('editor.generatePDF');
    Route::get('/editor/generateKeyPDF', 'generateKeyPDF')->name('editor.generateKeyPDF');
    Route::delete('/editor/deleteWorksheet', 'deleteWorksheet')->name('editor.deleteWorksheet');
    Route::post('/editor/generateExercise', 'generateExercise')->name('editor.generateExercise');
    Route::post('/editor/generateWorksheet', 'generateWorksheet')->name('editor.generateWorksheet');
});

Route::middleware('auth')->controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'showProfile')->name('show.profile');
    Route::get('/archive', 'showArchive')->name('show.archive');
    Route::post('/editor/show', 'showWorksheet')->name('editor.show');
    Route::post('/profile/edit', 'editProfile')->name('profile.edit');
});
