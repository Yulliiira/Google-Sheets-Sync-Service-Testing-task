<?php

use App\Http\Controllers\FetchController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\SheetConfigController;
use Illuminate\Support\Facades\Route;


Route::resource('/records', RecordController::class);
Route::post('records/generate', [RecordController::class, 'generate'])->name('records.generate');
Route::post('records/clear', [RecordController::class, 'clear'])->name('records.clear');

Route::get('/fetch/{count?}', [FetchController::class, 'fetch'])->name('fetch');

Route::get('/sheet-config', [SheetConfigController::class, 'create'])->name('sheet_config.create');
Route::post('/sheet-config', [SheetConfigController::class, 'store'])->name('sheet_config.store');
