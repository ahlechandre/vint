@extends('layouts.search', [
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
                'tabActive' => 'programs',
            ]) @endheadingSearch
        @endcell

        {{-- Paginável --}}
        @cell
            @paginablePrograms([
                'withoutSearch' => true,
                'programs' => $programs,
            ]) @endpaginablePrograms        
        @endcell        
    @endgridWithInner
@endsection