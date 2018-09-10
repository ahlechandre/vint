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
// Não autenticado
// ========================================================

Route::middleware('unauth')
    ->group(function () {
        // Registro de membro.
        Route::get('register', 'RegisterController@create');        
        Route::post('register', 'RegisterController@store');
    });

// ========================================================
// Autenticado
// ========================================================

Route::middleware('auth')
    ->group(function () {
        Route::resource('members', 'MemberController')
            ->only(['update']);

        // Membro > Papel
        Route::put('members/{member}/roles/{role}', 'MemberController@role');
    });

// ========================================================
// Público
// ========================================================

Route::resource('members', 'MemberController')
    ->only(['index', 'show']);
Route::get('members/{member}/programs', 'MemberController@programs');
Route::get('members/{member}/projects', 'MemberController@projects');
Route::get('members/{member}/groups', 'MemberController@groups');
Route::get('members/{member}/publications', 'MemberController@publications');