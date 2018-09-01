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

/**
 * -------------------------------------------------------
 * Rotas não autenticadas.
 * -------------------------------------------------------
 */
Route::middleware('unauth')
    ->group(function () {
        // Registro de membro.
        Route::get('register', 'RegisterController@create');        
        Route::post('register', 'RegisterController@store');
    });

/**
 * -------------------------------------------------------
 * Rotas autenticadas.
 * -------------------------------------------------------
 */
Route::middleware('auth')
    ->group(function () {});

/**
 * -------------------------------------------------------
 * Rotas públicas.
 * -------------------------------------------------------
 */
