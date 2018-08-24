@shape([
    'attrs' => array_merge([], $attrs ?? []),
    'classes' => array_merge(['shape-container-button'], $classes ?? []),
    'corners' => ['top-left', 'bottom-right']
])
    @button($button)
        {{ $slot }}    
    @endbutton
@endshape