<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Injeta o usuário em todos os layouts.
        view()->composer('*', function($view)
        {
            $view->with('user', request()->user());
        });

        // ----------------------------------------------
        // Alias 
        // ----------------------------------------------
        // Material
        Blade::component('material.layout-grid-inner', 'layoutGridInner');
        Blade::component('material.layout-grid-with-inner', 'layoutGridWithInner');
        Blade::component('material.cell', 'cell');
        Blade::component('material.card', 'card');
        Blade::component('material.button', 'button');
        Blade::component('material.button-link', 'buttonLink');
        Blade::component('material.textfield', 'textfield');
        Blade::component('material.textfield-textarea', 'textfieldTextarea');
        Blade::component('material.select', 'select');
        Blade::component('material.checkbox', 'checkbox');
        Blade::component('material.switch', 'switch');
        Blade::component('material.dialog', 'dialog');
        Blade::component('material.list-two-line', 'listTwoLine');
        Blade::component('material.list-two-line-with-link', 'listTwoLineWithLink');
        Blade::component('material.fab', 'fab');
        Blade::component('material.autocomplete', 'autocomplete');
        // Components
        Blade::component('components.chart', 'chart');
        Blade::component('components.form', 'form');
        Blade::component('components.form-with-card', 'formWithCard');
        Blade::component('components.paginable', 'paginable');
        Blade::component('components.count', 'count');
        Blade::component('components.article', 'article');
        Blade::component('components.expandable', 'expandable');
        Blade::component('components.resource-filter', 'resourceFilter');
        Blade::component('components.divider', 'divider');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
