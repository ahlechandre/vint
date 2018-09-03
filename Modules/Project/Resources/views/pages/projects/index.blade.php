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
                'content' => __('messages.projects.subheading'),
            ]) @endheading        
        @endcell
        
        @cell
            {{-- Paginável --}}
            @paginable([
                'paginator' => $projects,
                'list' => [
                    'isNavigation' => true,
                    'twoLine' => true,
                    'items' => $projects->map(function ($project) {
                        return [
                            'icon' => __('icons.project'),
                            'text' => [
                                'primary' => $project->name,
                                'secondary' => $project->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'icon' => __('icons.show'),
                            ],
                            'attrs' => [
                                'href' => url("projects/{$project->id}")
                            ]
                        ];
                    }),
                ]
            ]) @endpaginable        
        @endcell        
    @endgridWithInner
@endsection
