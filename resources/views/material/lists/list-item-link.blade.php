<a class="list-item mdc-list-item{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    @if ($icon ?? false)
        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">{{ $icon }}</span>    
    @endif

    @if (is_string($text))
        {{ $text }}
    @else
        <span class="mdc-list-item__text">
            <span class="mdc-list-item__primary-text">{{ $text['primary'] }}</span>
            <span class="mdc-list-item__secondary-text">{{ $text['secondary'] }}</span>
        </span>
    @endif

    @if ($meta ?? false)
        @if ($meta['icon'] ?? false)
            <span class="mdc-list-item__meta material-icons" aria-hidden="true">{{ $meta['icon'] }}</span>    
        @elseif ($meta['iconButton'] ?? false)
            @iconButton(component_with_classes($meta['iconButton'], [
                'mdc-list-item__meta'
            ])) @endiconButton
        @elseif ($meta['menuAnchor'] ?? false)
            @menuAnchor(component_with_classes($meta['menuAnchor'], [
                'mdc-list-item__meta'
            ])) @endmenuAnchor      
        @endif
    @endif
</a>
