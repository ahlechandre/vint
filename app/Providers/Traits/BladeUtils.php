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

        // Chips.
        'material.chips.chip-set' => 'chipSet',
        'material.chips.chip' => 'chip',

        // Dialogs.
        'material.dialogs.dialog' => 'dialog',
        'material.dialogs.dialog-container' => 'dialogContainer',

        // Drawers.
        'material.drawers.drawer-modal' => 'drawerModal',

        // Icons.
        'material.icons.icon' => 'icon',

        // Inputs and controls.
        'material.inputs.form-field' => 'formField',
        'material.inputs.checkbox' => 'checkbox',
        'material.inputs.radio' => 'radio',
        'material.inputs.switch' => 'materialSwitch',
        'material.inputs.select' => 'select',
        'material.inputs.text-field' => 'textfield',
        'material.inputs.text-field-outlined' => 'textfieldOutlined',
        'material.inputs.textarea' => 'textarea',      
        'material.inputs.select2' => 'select2',      
        'material.inputs.text-field-helper-text' => 'textfieldHelperText',
        'material.inputs.text-field-icon' => 'textfieldIcon',

        // Layout Grid.
        'material.layout-grid.layout-grid' => 'grid',
        'material.layout-grid.layout-grid-inner' => 'gridInner',
        'material.layout-grid.layout-grid-cell' => 'cell',
        'material.layout-grid.layout-grid-with-inner' => 'gridWithInner',

        // Lists.
        'material.lists.list' => 'list',
        'material.lists.list-item' => 'listItem',
        'material.lists.list-item-link' => 'listItemLink',
        'material.lists.list-item-meta' => 'listItemMeta',
        'material.lists.list-group' => 'listGroup',

        // Menus.
        'material.menus.menu-anchor' => 'menuAnchor',
        'material.menus.menu' => 'menu',
        
        // Shape.
        'material.shape.shape' => 'shape',
        'material.shape.shape-button' => 'shapeButton',
        'material.shape.shape-card' => 'shapeCard',

        // Shape.
        'material.snackbars.snackbar' => 'snackbar',

        // Tab bars.
        'material.tabs.tab-bar' => 'tabBar',
        'material.tabs.tab' => 'tab',
        'material.tabs.tab-indicator' => 'tabIndicator',

        // Top App Bar.
        'material.top-app-bar.top-app-bar' => 'topAppBar',

        /**
         * -------------------------------------
         * Components.
         * -------------------------------------
         */

        // Cards.
        'components.cards.card-header' => 'cardHeader',
        'components.cards.card-content' => 'cardContent',
        'components.cards.card-paper' => 'cardPaper',
        'components.cards.card-show' => 'cardShow',
        'components.cards.card-description' => 'cardDescription',
        
        // Count
        'components.count.count' => 'count',

        // Forms.
        'components.forms.form' => 'form',

        // Heading.
        'components.heading.heading' => 'heading',
        'components.heading.heading-group' => 'headingGroup',
        'components.heading.heading-member' => 'headingMember',
        'components.heading.heading-program' => 'headingProgram',
        'components.heading.heading-project' => 'headingProject',
        'components.heading.heading-publication' => 'headingPublication',
        'components.heading.heading-product' => 'headingProduct',
        'components.heading.heading-settings' => 'headingSettings',
        'components.heading.heading-group-edit' => 'headingGroupEdit',
        'components.heading.heading-search' => 'headingSearch',

        // Pagination.
        'components.pagination.paginable' => 'paginable',
        'components.pagination.paginable-members' => 'paginableMembers',
        'components.pagination.paginable-groups' => 'paginableGroups',
        'components.pagination.paginable-programs' => 'paginablePrograms',
        'components.pagination.paginable-projects' => 'paginableProjects',
        'components.pagination.paginable-products' => 'paginableProducts',
        'components.pagination.paginable-publications' => 'paginablePublications',

        // Footer.
        'components.footer.footer-default' => 'footerDefault',

        // Top app bar.
        'components.top-app-bar.top-app-bar-home' => 'topAppBarHome',
        'components.top-app-bar.top-app-bar-default' => 'topAppBarDefault',
        
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