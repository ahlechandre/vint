<div class="chart" data-chart-api="{{ $api }}">
    @card([
        'title' => $title,
        'subtitle' => $subtitle,
    ])
        <div class="chart__container ct-chart {{ $ratioClass }}">
        </div>
    @endcard
</div>