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
                'tabActive' => 'publications',
            ]) @endheadingSearch
        @endcell

        {{-- Paginável --}}
        @cell
            @paginablePublications([
                'withoutSearch' => true,
                'publications' => $publications,
            ]) @endpaginablePublications
        @endcell
    @endgridWithInner
@endsection