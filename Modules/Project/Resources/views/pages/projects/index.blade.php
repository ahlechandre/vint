@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.projects'),
            'attrs' => [
                'href' => url('projects')
            ],
        ]
    ]
])
@section('title', __('resources.projects'))

@section('main')

    {{-- Conteúdo --}}
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        {{-- Títulos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @article([
                'title' => __('resources.projects'),
                'intro' => __('messages.projects.index'),
            ]) @endarticle
        @endcell

        {{-- Mostra se o usuário pode atualizar solicitações --}}
        @can('updateRequests', \Modules\Project\Entities\Project::class)
            
            {{-- Solicitações de projecta --}}
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @buttonLink([
                    'text' => __('headlines.requests') . (
                        $projectRequestsCount ? (
                            $projectRequestsCount < 99 ?
                                " ({$projectRequestsCount})" : ' (+99)'
                        ) : ''
                    ),
                    'modifiers' => ['mdc-button--unelevated'],
                    'attrs' => [
                        'href' => url('project-requests')
                    ],
                ]) @endbuttonLink
            @endcell
        @endcan

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
                'collection' => $projects,
                'items' => $projects->map(function ($project) {
                    return [
                        'icon' => __('material_icons.project'),
                        'meta' => [
                            'icon' => __('material_icons.forward'),
                        ],
                        'text' => $project->name,
                        'secondaryText' => $project->created_at
                            ->diffForHumans(),
                        'attrs' => [
                            'href' => url("projects/{$project->id}"),
                        ]
                    ];
                }),
            ]) @endpaginable

            {{-- FAB --}}
            @can('create', \Modules\Project\Entities\Project::class)
                @fab([
                    'icon' => 'add',
                    'label' => __('messages.projects.new'),
                    'modifiers' => ['fab--fixed'],
                    'attrs' => [
                        'href' => url("projects/create"),
                        'title' => __('messages.projects.new'),
                        'alt' => __('messages.projects.new'),
                    ],
                ]) @endfab
            @endcan            
        @endcell
    @endlayoutGridWithInner

@endsection
