@if ($isNavigation ?? false)
    <nav class="list mdc-list{{ set_classes($classes ?? []) }}{{ isset($twoLine) && $twoLine ? ' mdc-list--two-line' : '' }}" aria-orientation="vertical"{{ set_attrs($attrs ?? []) }}>
        @if ($items ?? false)
            @if ($isMenu ?? false)
                @foreach ($items as $item)
                    @if (!isset($item['ignore']) || !$item['ignore'])
                        @listItemLink(component_with_attrs($item, [
                            'role' => 'menuitem',
                            'tabindex' => '0'
                        ])) @endlistItemLink           
                    @endif
                @endforeach            
            @else
                @foreach ($items as $item)
                    @if (!isset($item['ignore']) || !$item['ignore'])
                        @listItemLink($item) @endlistItemLink
                    @endif
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
                    @if (!isset($item['ignore']) || !$item['ignore'])
                        @listItem(component_with_attrs($item, [
                            'role' => 'menuitem',
                            'tabindex' => '0'
                        ])) @endlistItem
                    @endif
                @endforeach            
            @else
                @foreach ($items as $item)
                    @if (!isset($item['ignore']) || !$item['ignore'])
                        @listItem($item) @endlistItem
                    @endif
                @endforeach
            @endif
        @endif
        {{ $slot }}
    </ul>
@endif