{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.programs')
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
                'title' => __('resources.programs'),
                'content' => __('messages.programs.index'),
            ]) @endheading        
        @endcell
        
        {{-- Paginável --}}
        @cell
            @paginablePrograms([
                'programs' => $programs,
            ]) @endpaginablePrograms
        @endcell
    @endgridWithInner
@endsection
