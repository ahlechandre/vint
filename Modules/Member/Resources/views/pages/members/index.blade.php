{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.members')
])

{{-- Conteúdo --}}
@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        @cell
            {{-- Heading --}}
            @heading([
                'title' => __('resources.members'),
                'content' => __('messages.members.index'),
            ]) @endheading
        @endcell
        
        @cell
            @paginableMembers([
                'members' => $members,
            ]) @endpaginableMembers
        @endcell        
    @endgridWithInner
@endsection
