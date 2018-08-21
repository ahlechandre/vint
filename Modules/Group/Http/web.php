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

Route::middleware('unauth')
    ->group(function () {
        /**
         * ----------------------------------------
         * Registro de membro
         * ----------------------------------------
         */
        Route::get('register', 'RegisterController@create');        
        Route::post('register', 'RegisterController@store');        
    });

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
         * Grupos / Coordenadores
         * ----------------------------------------
         */
        Route::resource('groups/{group}/coordinators', 'CoordinatorController')
            ->only(['store', 'update', 'destroy']);
        
        /**
         * ----------------------------------------
         * Grupos / Membros
         * ----------------------------------------
         */
        Route::put('groups/{group}/member-requests/{member?}', 'GroupController@approveMembers');
        Route::delete('groups/{group}/member-requests/{member?}', 'GroupController@denyMembers');
        /**
         * ----------------------------------------
         * Grupos / Papéis
         * ----------------------------------------
         */
        Route::resource('groups/{group}/group-roles', 'GroupRoleController')
            ->only(['update']);
        /**
         * ----------------------------------------
         * Membros
         * ----------------------------------------
         */
        Route::resource('members', 'MemberController')->only([
            'index', 'show', 'edit', 'update'
        ]);
        /**
         * ----------------------------------------
         * Membros / Papel
         * ----------------------------------------
         */
        Route::put('members/{member}/role/{role}', 'MemberController@role');
        /**
         * ----------------------------------------
         * Membros / Requisições
         * ----------------------------------------
         */
        Route::get('member-requests', 'MemberController@requests');
        Route::put('member-requests/{member?}', 'MemberController@approve');
        Route::delete('member-requests/{member?}', 'MemberController@deny');
    });
