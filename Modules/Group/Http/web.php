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

        // -------------------------------------------
        // Grupos
        // -------------------------------------------

        Route::resource('groups', 'GroupController')
            ->only(['create', 'store', 'edit', 'update']);        

        // -------------------------------------------
        // Membros de grupo
        // -------------------------------------------

        Route::put('groups/{group}/members-toggle/{member}', 'GroupMemberController@toggle');
        Route::delete('groups/{group}/members/{member}', 'GroupMemberController@detach');
        Route::get('groups/{group}/members/requests', 'GroupMemberController@requests');
        Route::put('groups/{group}/members/requests/{member?}', 'GroupMemberController@approve');
        Route::delete('groups/{group}/members/requests/{member?}', 'GroupMemberController@deny');

        // -------------------------------------------
        // Programas de grupo
        // -------------------------------------------

        Route::resource('groups/{group}/programs', 'GroupProgramController')
            ->only(['create', 'store']);
        Route::get('groups/{group}/programs/requests', 'GroupProgramController@requests');
        Route::put('groups/{group}/programs/requests/{program?}', 'GroupProgramController@approve');
        Route::delete('groups/{group}/programs/requests/{program?}', 'GroupProgramController@deny');

        // -------------------------------------------
        // Projetos de grupo
        // -------------------------------------------

        Route::resource('groups/{group}/projects', 'GroupProjectController')
            ->only(['create', 'store']);            
        Route::get('groups/{group}/projects/requests', 'GroupProjectController@requests');
        Route::put('groups/{group}/projects/requests/{project?}', 'GroupProjectController@approve');
        Route::delete('groups/{group}/projects/requests/{project?}', 'GroupProjectController@deny');
    });

// ========================================================
// Público
// ========================================================

// -------------------------------------------
// Grupos
// -------------------------------------------

Route::resource('groups', 'GroupController')
    ->only(['index', 'show']);
Route::resource('groups/{group}/members', 'GroupMemberController')
    ->only(['index']);
Route::get('groups/{group}/programs', 'GroupProgramController@index');
Route::get('groups/{group}/projects', 'GroupProjectController@index');
