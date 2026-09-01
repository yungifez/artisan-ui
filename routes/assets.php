<?php

use Illuminate\Support\Facades\Route;

Route::prefix('april-ui')->name('april-ui.')->group(function () {
    $distPath = __DIR__.'/../dist/';

    Route::get('/april.js', function () use ($distPath) {
        return response()->file($distPath.'april.js', [
            'Content-Type' => 'text/javascript; charset=utf-8',
        ]);
    })->name('april.js');

    Route::get('/april.min.js', function () use ($distPath) {
        return response()->file($distPath.'april.min.js', [
            'Content-Type' => 'text/javascript; charset=utf-8',
        ]);
    })->name('april.min.js');

    Route::get('/editor.js', function () use ($distPath) {
        return response()->file($distPath.'editor.js', [
            'Content-Type' => 'text/javascript; charset=utf-8',
        ]);
    })->name('editor.js');

    Route::get('/editor.min.js', function () use ($distPath) {
        return response()->file($distPath.'editor.min.js', [
            'Content-Type' => 'text/javascript; charset=utf-8',
        ]);
    })->name('editor.min.js');

    Route::get('/april.css', function () use ($distPath) {
        return response()->file($distPath.'april.css', [
            'Content-Type' => 'text/css; charset=utf-8',
        ]);
    })->name('april.css');

    Route::get('/april.min.css', function () use ($distPath) {
        return response()->file($distPath.'april.min.css', [
            'Content-Type' => 'text/css; charset=utf-8',
        ]);
    })->name('april.min.css');
});

// Route::get('/april-ui/april.min.js');
