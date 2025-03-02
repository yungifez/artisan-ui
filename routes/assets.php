<?php

use Illuminate\Support\Facades\Route;

Route::prefix('artisan-ui')->name('artisan-ui.')->group(function () {
    $distPath = __DIR__.'/../dist/';

    Route::get('/artisan.js', function () use ($distPath) {
        return response()->file($distPath.'artisan.js', [
            'Content-Type' => 'text/javascript; charset=utf-8',
        ]);
    })->name('artisan.js');

    Route::get('/artisan.min.js', function () use ($distPath) {
        return response()->file($distPath.'artisan.min.js', [
            'Content-Type' => 'text/javascript; charset=utf-8',
        ]);
    })->name('artisan.min.js');

    Route::get('/artisan.css', function () use ($distPath) {
        return response()->file($distPath.'artisan.css', [
            'Content-Type' => 'text/css; charset=utf-8',
        ]);
    })->name('artisan.css');

    Route::get('/artisan.min.css', function () use ($distPath) {
        return response()->file($distPath.'artisan.min.css', [
            'Content-Type' => 'text/css; charset=utf-8',
        ]);
    })->name('artisan.min.css');
});

// Route::get('/artisan-ui/artisan.min.js');
