{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.projects')
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
                'title' => __('resources.projects'),
                'content' => __('messages.projects.index'),
            ]) @endheading
        @endcell
        
        {{-- Paginável --}}
        @cell
            @paginableProjects([
                'projects' => $projects,
            ]) @endpaginableProjects
        @endcell
    @endgridWithInner
@endsection
