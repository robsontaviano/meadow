<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware('web')->prefix(config('meadow.route_prefix'))->get('/meadow/toogle-sidebar', function (Request $request) {
    if ($request->collapsed) {
        session(['meadow-sidebar-collapsed' => $request->collapsed]);
    }
})->name('meadow.toogle-sidebar');

Route::middleware('web')->prefix(config('meadow.route_prefix'))->get('/meadow/spotlight', function (Request $request) {
    return app()->make(config('meadow.components.spotlight.class'))->search($request);
})->name('meadow.spotlight');

Route::middleware(['web', 'auth'])->prefix(config('meadow.route_prefix'))->post('/meadow/upload', function (Request $request) {
    $disk = $request->disk ?? 'public';
    $folder = $request->folder ?? 'editor';

    $file = Storage::disk($disk)->put($folder, $request->file('file'), 'public');
    $url = Storage::disk($disk)->url($file);

    return ['location' => $url];
})->name('meadow.upload');
