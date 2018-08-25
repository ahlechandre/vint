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
         * -------------------------------------
         * MDC Components.
         * -------------------------------------
         */

        // Buttons.
        'material.buttons.button' => 'button',
        'material.buttons.button-link' => 'buttonLink',
        'material.buttons.fab' => 'fab',
        'material.buttons.fab-fixed' => 'fabFixed',
        'material.buttons.icon-button' => 'iconButton',
        
        // Cards.
        'material.cards.card' => 'card',
        'material.cards.card-paper' => 'cardPaper',

        // Chips.
        'material.chips.chip-set' => 'chipSet',
        'material.chips.chip' => 'chip',

        // Dialogs.
        'material.dialogs.dialog' => 'dialog',
        'material.dialogs.dialog-container' => 'dialogContainer',

        // Drawers.
        'material.drawers.drawer-temporary' => 'drawerTemporary',

        // Icons.
        'material.icons.icon' => 'icon',

        // Layout Grid.
        'material.layout-grid.layout-grid' => 'grid',
        'material.layout-grid.layout-grid-inner' => 'gridInner',
        'material.layout-grid.layout-grid-cell' => 'cell',
        'material.layout-grid.layout-grid-with-inner' => 'gridWithInner',

        // Lists.
        'material.lists.list' => 'list',
        'material.lists.list-item' => 'listItem',
        'material.lists.list-item-link' => 'listItemLink',
        'material.lists.list-group' => 'listGroup',

        // Menus.
        'material.menus.menu-anchor' => 'menuAnchor',
        'material.menus.menu' => 'menu',
        
        // Shape.
        'material.shape.shape' => 'shape',
        'material.shape.shape-button' => 'shapeButton',
        'material.shape.shape-card' => 'shapeCard',

        // Top App Bar.
        'material.top-app-bar.top-app-bar' => 'topAppBar',
        'material.top-app-bar.top-app-bar-home' => 'topAppBarHome',

        /**
         * -------------------------------------
         * Components.
         * -------------------------------------
         */

        // Heading.
        'components.heading' => 'heading',

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