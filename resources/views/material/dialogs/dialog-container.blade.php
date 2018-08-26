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
    @endif

    @dialog(component_with_classes($dialog, [
        'dialog-container__dialog'
    ]))
        {{ $slot }}
    @enddialog
</span>