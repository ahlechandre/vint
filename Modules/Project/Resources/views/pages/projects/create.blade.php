@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.projects'),
            'attrs' => [
                'href' => url('projects')
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('projects/create')
            ]
        ]
    ],
])
@section('title', __('resources.projects') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => __('resources.projects'),
                'subtitle' => __('messages.projects.create'),
            ])
                @form([
                    'action' => url('projects'),
                    'method' => 'post',
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
                            'groups' => $groups ?? null,
                            'groupId' => old('group_id'),
                            'programId' => old('program_id'),
                            'leaderUserId' => old('leader_user_id'),
                            'supporterUserId' => old('supporter_user_id'),
                            'coordinatorUserId' => old('coordinator_user_id'),
                            'name' => old('name'),
                            'description' => old('description'),
                            'startOn' => old('start_on') ?? now()->format('Y-m-d'),
                            'finishOn' => old('finish_on') ?? now()->addYears(1)->format('Y-m-d')
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
