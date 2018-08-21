@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.projects'),
            'attrs' => [
                'href' => url('projects')
            ]
        ],
        [
            'text' => $project->name,
            'attrs' => [
                'href' => url("projects/{$project->id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("projects/{$project->id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.projects') . " / {$project->id} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        {{-- Formulário --}}
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $project->name,
                'subtitle' => __('messages.projects.edit'),
            ])
                @form([
                    'action' => url("projects/{$project->id}"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-project'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,             
                    'inputs' => [
                        'view' => 'project::inputs.project',
                        'props' => [
                            'collaborators' => $collaborators,
                            'programs' => $programs,
                            'professors' => $professors,
                            'servants' => $servants,
                            'programId' => $project->program_id,
                            'leaderUserId' => $project->leader_user_id,
                            'supporterUserId' => $project->supporter_user_id,
                            'coordinatorUserId' => $project->coordinator_user_id,
                            'name' => $project->name,
                            'description' => $project->description,
                            'startOn' => $project->start_on
                                ->format('Y-m-d'),
                            'finishOn' => $project->finish_on ? 
                                $project->finish_on
                                    ->format('Y-m-d') : null
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell

        @can('delete', $project)
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @button([
                    'text' => __('actions.delete'),
                    'icon' => 'delete_outline',
                    'attrs' => [
                        'type' => 'button',
                        'id' => 'dialog-activation-project-destroy'
                    ]
                ]) @endbutton
            @endcell

            {{-- Ao tentar remover --}}
            @form([
                'method' => 'delete',
                'action' => url("projects/{$project->id}"),
            ])
                {{-- Diálogo --}}
                @dialog([
                    'activation' => 'dialog-activation-project-destroy',
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
                        'id' => 'dialog-project-destroy'
                    ],
                    'title' => __('messages.projects.dialog.destroy_title')
                ])
                    {{ __('messages.projects.dialog.destroy_body') }}
                @enddialog
            @endform
        @endcan
    @endlayoutGridWithInner
    
@endsection
