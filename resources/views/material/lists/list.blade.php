@if ($isNavigation ?? false)
    <nav class="list mdc-list{{ set_classes($classes ?? []) }}{{ isset($twoLine) && $twoLine ? ' mdc-list--two-line' : '' }}" aria-orientation="vertical"{{ set_attrs($attrs ?? []) }}>
        @if ($items ?? false)
            @if ($isMenu ?? false)
                @foreach ($items as $item)
                    @listItemLink(component_with_attrs($item, [
                        'role' => 'menuitem',
                        'tabindex' => '0'
                    ])) @endlistItemLink
                @endforeach            
            @else
                @foreach ($items as $item)
                    @listItemLink($item) @endlistItemLink
                @endforeach
            @endif
        @endif
        {{ $slot }}
    </nav>
@else
    <ul class="list mdc-list{{ set_classes($classes ?? []) }}{{ isset($twoLine) && $twoLine ? ' mdc-list--two-line' : '' }}" aria-orientation="vertical"{{ set_attrs($attrs ?? []) }}>
        @if ($items ?? false)
            @if ($isMenu ?? false)
                @foreach ($items as $item)
                    @listItem(component_with_attrs($item, [
                        'role' => 'menuitem',
                        'tabindex' => '0'
                    ])) @endlistItem
                @endforeach            
            @else
                @foreach ($items as $item)
                    @listItem($item) @endlistItem
                @endforeach
            @endif
        @endif
        {{ $slot }}
    </ul>
@endif