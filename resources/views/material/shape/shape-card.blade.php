@shape([
    'attrs' => array_merge([], $attrs ?? []),
    'classes' => array_merge(['shape-container-card'], $classes ?? []),
    'corners' => ['top-right', 'bottom-left']
])
    @card($card)
        {{ $slot }}
    @endcard
@endshape