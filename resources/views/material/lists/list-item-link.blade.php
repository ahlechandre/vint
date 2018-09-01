@if ($dividerBefore ?? false)
    <li role="separator" class="mdc-list-divider"></li>
@endif

<a class="list-item mdc-list-item{{ set_classes($classes ?? []) }}{{ isset($active) && $active ? ' mdc-list-item--activated' : '' }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
    @if ($icon ?? false)
        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">{{ $icon }}</span>    
    @endif

    @if (is_string($text))
        {{ $text }}
    @else
        <span class="mdc-list-item__text">
            @if ($text['link'] ?? false)
                <a class="mdc-list-item__primary-text" href="{{ $text['link'] }}">{{ $text['primary'] }}</a>
            @else 
                <span class="mdc-list-item__primary-text">{{ $text['primary'] }}</span>        
            @endif
            <span class="mdc-list-item__secondary-text">{{ $text['secondary'] }}</span>
        </span>
    @endif

    @if ($meta ?? false)
        @listItemMeta($meta) @endlistItemMeta
    @elseif ($metas ?? false)
        <span class="mdc-list-item__meta">
            @foreach($metas as $meta)
                @listItemMeta($meta) @endlistItemMeta    
            @endforeach         
        </span>
    @endif
</a>
