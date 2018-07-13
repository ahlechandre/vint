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
        /**
         * ----------------------------------------
         * Dashboard 
         * ----------------------------------------
         */
        Route::get('/dashboard', 'DashboardController@index');
        /**
         * ----------------------------------------
         * Usuários 
         * ----------------------------------------
         */
        Route::get('users/{id}/password', 'UserController@editPassword');
        Route::put('users/{id}/password', 'UserController@updatePassword');
        /**
         * ----------------------------------------
         * Usuários 
         * ----------------------------------------
         */
        Route::resource('users', 'UserController')
            ->except(['destroy']);
    });
