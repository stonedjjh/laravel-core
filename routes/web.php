<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-layout', function () {
    return view('test-layout');
})->name('dashboard'); // Le colocamos el nombre 'dashboard' para que coincida con el parámetro de los componentes