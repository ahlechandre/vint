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
                'content' => __('messages.programs.subheading'),
            ]) @endheading        
        @endcell
        
        @cell
            {{-- Paginável --}}
            @paginable([
                'paginator' => $programs,
                'list' => [
                    'isNavigation' => true,
                    'twoLine' => true,
                    'items' => $programs->map(function ($program) {
                        return [
                            'icon' => __('icons.program'),
                            'text' => [
                                'primary' => $program->name,
                                'secondary' => $program->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'icon' => __('icons.show'),
                            ],
                            'attrs' => [
                                'href' => url("programs/{$program->id}")
                            ]
                        ];
                    }),
                ]
            ]) @endpaginable        
        @endcell        
    @endgridWithInner
@endsection
