<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\WorksheetController;

Route::get('/', [PagesController::class,'index'])->name('show.index');

Route::post('/logout',[AuthController::class,'logout'])->name('logout');

Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('/login','showLogin')->name('show.login');
    Route::get('/register','showRegister')->name('show.register');
    Route::post('/login','login')->name('login');
    Route::post('/register','register')->name('register');
});

Route::middleware(['auth','can:admin'])->controller(PagesController::class)->group(function(){
    Route::get('/admin','admin')->name('show.admin');
    Route::delete('/admin','delete')->name('admin.delete');
});

Route::middleware('auth')->controller(WorksheetController::class)->group(function(){
    Route::post('/editor','create')->name('show.editor');
    Route::get('/editor/generate','generatePDF')->name('editor.generate');
});
