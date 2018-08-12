@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.project-requests'),
            'attrs' => [
                'href' => url('project-requests')
            ],
        ]
    ]
])
@section('title', __('resources.project-requests'))

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
                'title' => __('resources.project_requests'),
                'intro' => __('messages.project_requests.index'),
            ]) @endarticle
        @endcell
        
        {{-- Ações --}}
        @cell([
            'when' => ['default' => 12],
            'modifiers' => ['mdc-layout-grid--align-right']
        ])
            {{-- Aprovar todos --}}
            @button([
                'text' => __('actions.approve_all'),
                'modifiers' => ['mdc-button--unelevated'],
                'icon' => __('material_icons.approve_all'),
                'attrs' => [
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Project::class),
                    'id' => 'dialog-activation-approve-project-requests',
                    'type' => 'button'
                ],
            ]) @endbutton

            {{-- Remover todos --}}
            @button([
                'text' => __('actions.deny_all'),
                'icon' => __('material_icons.deny_all'),
                'attrs' => [
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Project::class),
                    'id' => 'dialog-activation-deny-project-requests',
                    'type' => 'button'
                ],
            ]) @endbutton
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @layoutGridInner
                @foreach ($projects as $project)
                    @cell([
                        'when' => ['d' => 6, 't' => 4, 'p' => 4]
                    ])
                        {{-- Member request card --}}
                        @cardProjectRequest([
                            'project' => $project
                        ]) @endcardProjectRequest     
                    @endcell
                @endforeach
            @endlayoutGridInner
        @endcell
    @endlayoutGridWithInner

    @can('updateRequests', \Modules\Project\Entities\Project::class)
        {{-- Ao tentar aprovar todos --}}
        @form([
            'method' => 'put',
            'action' => url("project-requests"),
        ])
            {{-- Diálogo --}}
            @dialog([
                'activation' => 'dialog-activation-approve-project-requests',
                'cancel' => [
                    'text' => __('actions.cancel'),
                    'attrs' => [
                        'type' => 'button' 
                    ],
                ],
                'accept' => [
                    'text' => __('actions.confirm'),
                    'attrs' => [
                        'type' => 'submit'
                    ],
                ],
                'attrs' => [
                    'id' => 'dialog-approve-project-requests'
                ],
                'title' => __('messages.project_requests.dialog.approve_all_title')
            ])
                {{ __('messages.project_requests.dialog.approve_all_body', [
                    'count' => $projects->count()
                ]) }}
            @enddialog
        @endform

        {{-- Ao tentar recusar todos --}}
        @form([
            'method' => 'delete',
            'action' => url('project-requests'),
        ])
            {{-- Diálogo --}}
            @dialog([
                'activation' => 'dialog-activation-deny-project-requests',
                'cancel' => [
                    'text' => __('actions.cancel'),
                    'attrs' => [
                        'type' => 'button' 
                    ],
                ],
                'accept' => [
                    'text' => __('actions.confirm'),
                    'attrs' => [
                        'type' => 'submit'
                    ],
                ],
                'attrs' => [
                    'id' => 'dialog-deny-project-requests'
                ],
                'title' => __('messages.project_requests.dialog.deny_all_title')
            ])
                {{ __('messages.project_requests.dialog.deny_all_body', [
                    'count' => $projects->count()
                ]) }}
            @enddialog
        @endform
        
    @endcan
@endsection
