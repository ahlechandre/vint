@layoutGrid($grid ?? [])
    @layoutGridInner($inner ?? [])
        {{ $slot }}
    @endlayoutGridInner
@endlayoutGrid