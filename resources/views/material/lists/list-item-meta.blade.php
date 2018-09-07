@if (!isset($ignore) || !$ignore)
    @if ($icon ?? false)
        <span class="mdc-list-item__meta material-icons" aria-hidden="true">{{ $icon }}</span>    
    @elseif ($iconButton ?? false)
        @iconButton(component_with_classes($iconButton, [
            'mdc-list-item__meta'
        ])) @endiconButton
    @elseif ($menuAnchor ?? false)
        @menuAnchor(component_with_classes($menuAnchor, [
            'mdc-list-item__meta'
        ])) @endmenuAnchor
    @elseif ($dialogContainer ?? false)
        @dialogContainer(component_with_classes($dialogContainer, [
            'mdc-list-item__meta'
        ])) @enddialogContainer    
    @endif
@endif