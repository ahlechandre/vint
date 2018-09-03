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

// ========================================================
// Autenticado
// ========================================================

Route::middleware('auth')
    ->group(function () {

        // Painel de controle
        Route::get('/dashboard', 'DashboardController@index');

        // --------------------------------------------------------
        // Usuários
        // --------------------------------------------------------
        Route::resource('users', 'UserController')
            ->except(['destroy']);
        Route::put('users/{id}/password', 'UserController@password');

        // Configurações
        Route::get('settings', 'UserController@settings');
    });
