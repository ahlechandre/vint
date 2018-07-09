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
         * Log out 
         * ----------------------------------------
         */
        Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
        /**
         * ----------------------------------------
         * Papéis
         * ----------------------------------------
         */
        Route::resource('roles', 'RoleController')->except([
            'destroy'
        ]);
    });

Route::middleware('unauth')
    ->group(function () {
        /**
         * ---------------------------------------
         * Login
         * ---------------------------------------
         */
        Route::get('/login', '\App\Http\Controllers\Auth\LoginController@login')
            ->name('login');
        Route::post('/login', '\App\Http\Controllers\Auth\LoginController@authenticate');
    });