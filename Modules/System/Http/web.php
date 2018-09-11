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

// -------------------------------------------------------
// Autenticado.
// -------------------------------------------------------
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

// -------------------------------------------------------
// Não autenticado.
// -------------------------------------------------------
Route::middleware('unauth')
    ->group(function () {
        /**
         * Home Page
         */
        Route::get('/', function () {
            return view('system::pages.home.index');
        });

        /**
         * ---------------------------------------
         * Login
         * ---------------------------------------
         */
        Route::get('/login', '\App\Http\Controllers\Auth\LoginController@login')
            ->name('login');
        Route::post('/login', '\App\Http\Controllers\Auth\LoginController@authenticate');
    });

// -------------------------------------------------------
// Público.
// -------------------------------------------------------
Route::get('search', 'SearchController@index');
Route::get('search/members', 'SearchController@members');
Route::get('search/groups', 'SearchController@groups');
Route::get('search/programs', 'SearchController@programs');
Route::get('search/projects', 'SearchController@projects');
Route::get('search/products', 'SearchController@products');
Route::get('search/publications', 'SearchController@publications');