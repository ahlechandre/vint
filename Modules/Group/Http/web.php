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
 * Rotas autenticadas.
 * -------------------------------------------------------
 */
Route::middleware('auth')
    ->group(function () {
        // Grupos
        Route::resource('groups', 'GroupController')
            ->only(['create', 'store', 'edit', 'update']);

        // Grupo > Membro
        Route::put('groups/{group}/members/{member}', 'GroupMemberController@toggle');

        // Grupo > Programas
        Route::resource('groups/{group}/programs', 'GroupProgramController')
            ->only(['create', 'store']);

        // Programas
        Route::resource('programs', 'ProgramController')
            ->only(['edit', 'update']);


        // /**
        //  * ----------------------------------------
        //  * Grupos / Coordenadores
        //  * ----------------------------------------
        //  */
        // Route::resource('groups/{group}/coordinators', 'CoordinatorController')
        //     ->only(['store', 'update', 'destroy']);
        
        // /**
        //  * ----------------------------------------
        //  * Grupos / Membros
        //  * ----------------------------------------
        //  */
        // Route::put('groups/{group}/member-requests/{member?}', 'GroupController@approveMembers');
        // Route::delete('groups/{group}/member-requests/{member?}', 'GroupController@denyMembers');
        // /**
        //  * ----------------------------------------
        //  * Grupos / Papéis
        //  * ----------------------------------------
        //  */
        // Route::resource('groups/{group}/group-roles', 'GroupRoleController')
        //     ->only(['update']);
        // /**
        //  * ----------------------------------------
        //  * Membros
        //  * ----------------------------------------
        //  */
        // Route::resource('members', 'MemberController')->only([
        //     'index', 'show', 'edit', 'update'
        // ]);
        // /**
        //  * ----------------------------------------
        //  * Membros / Papel
        //  * ----------------------------------------
        //  */
        // Route::put('members/{member}/role/{role}', 'MemberController@role');
        // /**
        //  * ----------------------------------------
        //  * Membros / Requisições
        //  * ----------------------------------------
        //  */
        // Route::get('member-requests', 'MemberController@requests');
        // Route::put('member-requests/{member?}', 'MemberController@approve');
        // Route::delete('member-requests/{member?}', 'MemberController@deny');
    });

/**
 * -------------------------------------------------------
 * Rotas públicas.
 * -------------------------------------------------------
 */

// Grupos
Route::resource('groups', 'GroupController')
    ->only(['index', 'show']);

// Grupo > Programas
Route::get('groups/{group}/programs', 'GroupProgramController@index');

// Programas
Route::resource('programs', 'ProgramController')
    ->only(['index', 'show']);
