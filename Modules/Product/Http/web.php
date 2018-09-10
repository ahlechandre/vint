<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('auth')
    ->group(function () {
        // --------------------------------------------------
        // Produtos
        // --------------------------------------------------
        Route::resource('products', 'ProductController')
            ->except(['index', 'show']);

        // --------------------------------------------------
        // Publicações
        // --------------------------------------------------
        Route::resource('publications', 'PublicationController')
            ->except(['index', 'show']);

    });

// --------------------------------------------------
// Produtos
// --------------------------------------------------
Route::resource('products', 'ProductController')
    ->only(['index', 'show']);
Route::get('products/{product}/projects', 'ProductController@projects');

// --------------------------------------------------
// Publicações
// --------------------------------------------------
Route::resource('publications', 'PublicationController')
    ->only(['index', 'show']);
Route::get('publications/{publication}/projects', 'PublicationController@projects');
Route::get('publications/{publication}/members', 'PublicationController@members');

