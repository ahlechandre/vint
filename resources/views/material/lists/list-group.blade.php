<div class="list-group mdc-list-group{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    @foreach ($groups as $group)
        {{-- Subheader --}}
        @if ($group['subheader'] ?? false)
            <h3 class="list-group__subheader mdc-list-group__subheader">{{ $group['subheader'] }}</h3>
        @endif
 
        {{-- List --}}
        @list($group['list']) @endlist

        {{-- Divider --}}
        @if (!$loop->last)
            <hr class="list-divider mdc-list-divider">        
        @endif
    @endforeach
</div>