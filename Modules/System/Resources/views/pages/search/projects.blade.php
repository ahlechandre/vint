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
                'tabActive' => 'projects',
            ]) @endheadingSearch
        @endcell

        {{-- Paginável --}}
        @cell
            @paginableProjects([
                'withoutSearch' => true,
                'projects' => $projects,
            ]) @endpaginableProjects        
        @endcell        
    @endgridWithInner
@endsection