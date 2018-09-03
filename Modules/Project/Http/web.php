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

        // Programas
        Route::resource('programs', 'ProgramController')
            ->only(['edit', 'update']);

        // Projetos
        Route::resource('projects', 'ProjectController')
            ->only(['edit', 'update']);

    });

// ========================================================
// Público
// ========================================================

// Programas
Route::resource('programs', 'ProgramController')
    ->only(['index', 'show']);
Route::get('programs/{program}/projects', 'ProgramController@projects');

// Projetos
Route::resource('projects', 'ProjectController')
    ->only(['index', 'show']);
Route::get('projects/{project}/students', 'ProjectController@students');
Route::get('projects/{project}/publications', 'ProjectController@publications');
Route::get('projects/{project}/products', 'ProjectController@products');
