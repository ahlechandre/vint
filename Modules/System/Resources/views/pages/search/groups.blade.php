@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('headlines.search')
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
                'tabActive' => 'groups',
            ]) @endheadingSearch
        @endcell

        {{-- Paginável --}}
        @cell
            @paginableGroups([
                'withoutSearch' => true,
                'groups' => $groups,
            ]) @endpaginableGroups        
        @endcell

    @endgridWithInner
@endsection