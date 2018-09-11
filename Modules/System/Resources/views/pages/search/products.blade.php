@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('headlines.search'),
    'searchVisible' => true,
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingSearch([
                'term' => $term,
                'tabActive' => 'products',
            ]) @endheadingSearch
        @endcell

        {{-- Paginável --}}
        @cell
            @paginableProducts([
                'withoutSearch' => true,
                'products' => $products,
            ]) @endpaginableProducts
        @endcell

    @endgridWithInner
@endsection