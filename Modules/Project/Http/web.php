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
         * Programas
         * ----------------------------------------
         */
        Route::resource('programs', 'ProgramController')
            ->except(['destroy']);
        /**
         * ----------------------------------------
         * Programas / Solicitações
         * ----------------------------------------
         */
        Route::get('program-requests', 'ProgramController@requests');
        Route::put('program-requests/{program?}', 'ProgramController@approve');
        Route::delete('program-requests/{program?}', 'ProgramController@deny');
        /**
         * ----------------------------------------
         * Projetos
         * ----------------------------------------
         */
        Route::resource('projects', 'ProjectController')
            ->except(['destroy']);
        /**
         * ----------------------------------------
         * Projetos / Solicitações
         * ----------------------------------------
         */
        Route::get('project-requests', 'ProjectController@requests');
        Route::put('project-requests/{project?}', 'ProjectController@approve');
        Route::delete('project-requests/{project?}', 'ProjectController@deny');        
    });