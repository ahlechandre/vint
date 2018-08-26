@card([
    'classes' => [
        'card--login',
    ]
])
    @cardHeader([
        'title' => $title,
        'subtitle' => $subtitle,
    ]) @endcardHeader

    @cardContent
        {{ $slot }}
    @endcardContent
@endcard