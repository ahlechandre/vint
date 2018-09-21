@card([
    'classes' => ['mdc-card--outlined']
])
    @cardContent
        <p class="mdc-typography--body1">{!! nl2br($slot) !!}</p>
    @endcardContent
@endcard