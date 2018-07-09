@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => 'Dashboard',
            'attrs' => [
                'href' => url('/dashboard')
            ],
        ]
    ],
])
@section('title', 'Dashboard')

@section('scripts')
    <script src="{{ asset('js/chartist.min.js') }}"></script>
    <script src="{{ asset('js/chartist-plugin-tooltip.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chartist-plugin-tooltip.css') }}">
@endsection

@section('main')
    @layoutGridWithInner

        @cell([
            'when' => ['desktop' => 4]
        ])
            @count([
                'title' => 'Item 1',
                'value' => 100,
                'trending' => 'up',
                'trendingValue' => '10.59%',
                'trendingIcon' => 'trending_up',
            ]) @endcount
        @endcell

        @cell([
            'when' => ['desktop' => 4]
        ])
            @count([
                'title' => 'Item 2',
                'value' => "R$ 260.1",
                'trending' => 'down',
                'trendingValue' => '42.93%',
                'trendingIcon' => 'trending_down',
            ]) @endcount
        @endcell

        @cell([
            'when' => ['desktop' => 4]
        ])
            @count([
                'title' => 'Item 3',
                'value' => 122,
                'trending' => 'flat',
                'trendingValue' => '0.12%',
                'trendingIcon' => 'trending_flat',
            ]) @endcount
        @endcell

        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8
            ]
        ])
            @chart([
                'title' => 'Chart 1',
                'subtitle' => 'Subtitle of chart 1',
                'ratioClass' => 'ct-major-twelfth',
                'api' => url('/api/charts/example'),
            ]) @endchart
        @endcell

    @endlayoutGridWithInner
@endsection