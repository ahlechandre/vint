<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('choices', function () {
    return response()->json([
        'data' => [
            [
                'id' => 1,
                'name' => 'Item 1'
            ],
            [
                'id' => 2,
                'name' => 'Item 2'
            ],
            [
                'id' => 3,
                'name' => 'Item 3'
            ],
            [
                'id' => 4,
                'name' => 'Item 4'
            ]
        ]
    ]);
});

Route::middleware('auth:api')
    ->group(function () {
        /**
         * ---------------------------------------------------
         * Usuários
         * ---------------------------------------------------
         */
        Route::resource('users', 'UserController')
            ->except(['destroy', 'create', 'edit']);
        /**
         * ---------------------------------------------------
         * Exemplo de API para gráficos
         * ---------------------------------------------------
         */
        Route::get('charts/example', function () {
            return response()->json([
                'type' => 'line',
                'data' => [
                    'labels' => ['item 1', 'item 2', 'item 3', 'item 4'],
                    'series' => [
                        [
                            [
                                'meta' => 'description 1',
                                'value' => 10
                            ],
                            [
                                'meta' => 'description 2',
                                'value' => 15
                            ],
                            [
                                'meta' => 'description 3',
                                'value' => 23
                            ],
                            [
                                'meta' => 'description 4',
                                'value' => 31
                            ],                            
                        ]
                    ],  
                ]
            ]);
        });
    });