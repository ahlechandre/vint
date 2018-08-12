@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.programs'),
            'attrs' => [
                'href' => url('programs')
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('programs/create')
            ]
        ]
    ],
])
@section('title', __('resources.programs') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => __('resources.programs'),
                'subtitle' => __('messages.programs.create'),
            ])
                @form([
                    'action' => url('programs'),
                    'method' => 'post',
                    'attrs' => [
                        'id' => 'form-program'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,            
                    'inputs' => [
                        'view' => 'project::inputs.program',
                        'props' => [
                            'servants' => $servants,
                            'groups' => $groups ?? null,
                            'groupId' => old('group_id'),
                            'name' => old('name'),
                            'coordinatorUserId' => old('coordinator_user_id'),
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
