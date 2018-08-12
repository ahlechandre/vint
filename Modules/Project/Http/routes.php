<?php

Route::group(['middleware' => 'web', 'prefix' => 'project', 'namespace' => 'Modules\Project\Http\Controllers'], function()
{
    Route::get('/', 'ProjectController@index');
});
