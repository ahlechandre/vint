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
                'tabActive' => 'members',
            ]) @endheadingSearch
        @endcell

        {{-- Paginável --}}
        @cell
            @paginableMembers([
                'withoutSearch' => true,
                'members' => $members,
            ]) @endpaginableMembers
        @endcell

    @endgridWithInner
@endsection