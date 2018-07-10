<?php

Route::group(['middleware' => 'web', 'prefix' => 'group', 'namespace' => 'Modules\Group\Http\Controllers'], function()
{
    Route::get('/', 'GroupController@index');
});
