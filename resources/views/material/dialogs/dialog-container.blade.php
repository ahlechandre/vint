<span class="dialog-container{{ set_classes($classes ?? []) }}" data-vint-auto-init="VintDialogContainer"{{ set_attrs($attrs ?? []) }}>
    @if ($button ?? false)
        @button(component_with_classes($button, [
            'dialog-container__activation'
        ])) @endbutton
    @elseif ($shapeButton ?? false)
        @shapeButton(component_with_classes($shapeButton, [
            'dialog-container__activation'
        ])) @endshapeButton
    @elseif ($iconButton ?? false)
        @iconButton(component_with_classes($iconButton, [
            'dialog-container__activation'
        ])) @endiconButton
    @elseif ($fabFixed ?? false)
        @fabFixed(component_with_classes($fabFixed, [
            'dialog-container__activation'
        ])) @endfabFixed                
    @endif

    @if ($form ?? false)
        @form($form)
            @dialog(component_with_classes($dialog, [
                'dialog-container__dialog'
            ]))
                {{ $slot }}
            @enddialog        
        @endform
    @else
        @dialog(component_with_classes($dialog, [
            'dialog-container__dialog'
        ]))
            {{ $slot }}
        @enddialog    
    @endif
</span>