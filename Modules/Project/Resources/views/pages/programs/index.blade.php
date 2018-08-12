@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.programs'),
            'attrs' => [
                'href' => url('programs')
            ],
        ]
    ]
])
@section('title', __('resources.programs'))

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
                'title' => __('resources.programs'),
                'intro' => __('messages.programs.index'),
            ]) @endarticle
        @endcell

        {{-- Mostra se o usuário pode atualizar solicitações --}}
        @can('updateRequests', \Modules\Project\Entities\Program::class)
            
            {{-- Solicitações de programa --}}
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @buttonLink([
                    'text' => __('headlines.requests') . (
                        $programRequestsCount ? (
                            $programRequestsCount < 99 ?
                                " ({$programRequestsCount})" : ' (+99)'
                        ) : ''
                    ),
                    'modifiers' => ['mdc-button--unelevated'],
                    'attrs' => [
                        'href' => url('program-requests')
                    ],
                ]) @endbuttonLink
            @endcell
        @endcan

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
                'collection' => $programs,
                'items' => $programs->map(function ($program) {
                    return [
                        'icon' => __('material_icons.program'),
                        'meta' => [
                            'icon' => __('material_icons.forward'),
                        ],
                        'text' => $program->name,
                        'secondaryText' => $program->created_at
                            ->diffForHumans(),
                        'attrs' => [
                            'href' => url("programs/{$program->id}"),
                        ]
                    ];
                }),
            ]) @endpaginable

            {{-- FAB --}}
            @can('create', \Modules\Project\Entities\Program::class)
                @fab([
                    'icon' => 'add',
                    'label' => __('messages.programs.new'),
                    'modifiers' => ['fab--fixed'],
                    'attrs' => [
                        'href' => url("programs/create"),
                        'title' => __('messages.programs.new'),
                        'alt' => __('messages.programs.new'),
                    ],
                ]) @endfab
            @endcan            
        @endcell
    @endlayoutGridWithInner

@endsection
