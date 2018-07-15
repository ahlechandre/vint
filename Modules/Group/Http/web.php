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
         * Grupos 
         * ----------------------------------------
         */
        Route::resource('groups', 'GroupController')
            ->except(['destroy']);
        /**
         * ----------------------------------------
         * Convites
         * ----------------------------------------
         */
        Route::resource('groups/{group}/invites', 'InviteController')
            ->only(['store', 'update', 'destroy']);
    });
