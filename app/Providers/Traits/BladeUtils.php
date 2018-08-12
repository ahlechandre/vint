<?php

namespace App\Providers\Traits;

use Illuminate\Support\Facades\Blade;

trait BladeUtils
{
    /**
     * @var array
     */
    protected $bladeComponents = [
        /**
         * Material.
         */
        'material.layout-grid-inner' => 'layoutGridInner',
        'material.layout-grid-with-inner' => 'layoutGridWithInner',
        'material.cell' => 'cell',
        'material.card' => 'card',
        'material.card-with-form' => 'cardWithForm',
        'material.button' => 'button',
        'material.button-link' => 'buttonLink',
        'material.textfield' => 'textfield',
        'material.textfield-textarea' => 'textarea',
        'material.select' => 'select',
        'material.checkbox' => 'checkbox',
        'material.switch' => 'materialSwitch',
        'material.dialog' => 'dialog',
        'material.list-two-line' => 'listTwoLine',
        'material.list-two-line-with-link' => 'listTwoLineWithLink',
        'material.fab' => 'fab',
        'material.autocomplete' => 'autocomplete',
        'material.menu' => 'menu',
        'material.menu-anchor' => 'menuAnchor',
        'material.menu-item' => 'menuItem',
        /**
         * Cards
         */
        'components.cards.card-member-request' => 'cardMemberRequest',
        'components.cards.card-program-request' => 'cardProgramRequest',
        'components.cards.card-project-request' => 'cardProjectRequest',
        /**
         * Forms.
         */
        'components.forms.form' => 'form',
        'components.forms.form-with-card' => 'formWithCard',
        /**
         * User Interface.
         */
        'components.ui.paginable' => 'paginable',
        'components.ui.count' => 'count',
        'components.ui.article' => 'article',
        'components.ui.expandable' => 'expandable',
        'components.ui.divider' => 'divider',
        /**
         * Chart.
         */
        'components.charts.chart', 'chart'          
    ];

    /**
     * @return void
     */
    public function mapComponentsToAliases()
    {
        foreach($this->bladeComponents as $component => $alias) {
            Blade::component($component, $alias);
        }
    }

    /**
     * @return void
     */
    public function registerBladeGlobals()
    {
        // Injeta o usuário em todos os layouts.
        view()->composer('*', function($view) {
            $view->with('user', request()->user());
        });        
    }
}