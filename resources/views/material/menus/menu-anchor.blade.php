<div class="menu-anchor mdc-menu-anchor">
    @if ($button ?? false)
        @button(component_with_classes($button, [
            'menu-anchor__button'
        ])) @endbutton
    @elseif ($shapeButton ?? false)
        @shapeButton(component_with_classes($shapeButton, [
            'menu-anchor__button'
        ])) @endshapeButton
    @elseif ($iconButton ?? false)
        @iconButton(component_with_classes($iconButton, [
            'menu-anchor__button'
        ])) @endiconButton        
    @endif

    @menu(component_with_classes($menu, [
        'menu-anchor__menu'
    ]))
        {{ $slot }}
    @endmenu    
</div>