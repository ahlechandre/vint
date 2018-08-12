@card([
    'title' => $project->name,
    'subtitle' => $project->created_at
        ->diffForHumans(),
    'actions' => [
        [
            'type' => 'button',
            'props' => [
                'text' => __('actions.approve'),
                'icon' => __('material_icons.approve'),
                'attrs' => [
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Project::class),
                    'id' => "dialog-activation-approve-project-request-{$project->id}",
                    'type' => 'button'
                ]                
            ]
        ],
        [
            'type' => 'button',
            'props' => [
                'text' => __('actions.deny'),
                'icon' => __('material_icons.deny'),
                'attrs' => [
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Project::class),
                    'id' => "dialog-activation-deny-project-request-{$project->id}",
                    'type' => 'button'
                ]
            ]
        ]
    ]
])
    {{-- Info --}}
    @listTwoLine([
        'items' => [
            [
                'icon' => __('material_icons.name'),
                'text' => __('attrs.name'),
                'secondaryText' => $project->name
            ],
            [
                'icon' => __('material_icons.description'),
                'text' => __('attrs.description'),
                'secondaryText' => $project->description
            ],
            [
                'icon' => __('material_icons.start_on'),
                'text' => __('attrs.start_on'),
                'secondaryText' => $project->start_on
                    ->diffForHumans(),
            ],
            [
                'icon' => __('material_icons.finish_on'),
                'text' => __('attrs.finish_on'),
                'secondaryText' => $project->finish_on ?
                    $project->finish_on
                        ->diffForHumans() : 'Não indicado',
            ],
            [
                'icon' => __('material_icons.coordinator'),
                'text' => __('attrs.coordinator'),
                'secondaryText' => $project->coordinator
                    ->member
                    ->user
                    ->name,
            ],
        ]
    ]) @endlistTwoLine
@endcard

@can('updateRequests', \Modules\Project\Entities\Project::class)
    {{-- Ao tentar aprovar --}}
    @form([
        'method' => 'put',
        'action' => url("project-requests/{$project->id}"),
    ])
        {{-- Diálogo --}}
        @dialog([
            'activation' => "dialog-activation-approve-project-request-{$project->id}",
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
                'id' => "dialog-approve-project-request-{$project->id}"
            ],
            'title' => __('messages.project_requests.dialog.approve_title')
        ])
            {{ __('messages.project_request.dialog.approve_body') }}
        @enddialog

    @endform

    {{-- Ao tentar remover --}}
    @form([
        'method' => 'delete',
        'action' => url("project-requests/{$project->id}"),
    ])
        {{-- Diálogo --}}
        @dialog([
            'activation' => "dialog-activation-deny-project-request-{$project->id}",
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
                'id' => "dialog-deny-project-request-{$project->id}"
            ],
            'title' => __('messages.project_requests.dialog.deny_title')
        ])
            {{ __('messages.project_requests.dialog.deny_body') }}
        @enddialog
    @endform
@endcan