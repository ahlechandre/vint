@card([
    'title' => $program->name,
    'subtitle' => $program->created_at
        ->diffForHumans(),
    'actions' => [
        [
            'type' => 'button',
            'props' => [
                'text' => __('actions.approve'),
                'icon' => __('material_icons.approve'),
                'attrs' => [
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Program::class),
                    'id' => "dialog-activation-approve-program-request-{$program->id}",
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
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Program::class),
                    'id' => "dialog-activation-deny-program-request-{$program->id}",
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
                'secondaryText' => $program->name
            ],
            [
                'icon' => __('material_icons.description'),
                'text' => __('attrs.description'),
                'secondaryText' => $program->description
            ],
            [
                'icon' => __('material_icons.start_on'),
                'text' => __('attrs.start_on'),
                'secondaryText' => $program->start_on
                    ->diffForHumans(),
            ],
            [
                'icon' => __('material_icons.finish_on'),
                'text' => __('attrs.finish_on'),
                'secondaryText' => $program->finish_on ?
                    $program->finish_on
                        ->diffForHumans() : 'Não indicado',
            ],
            [
                'icon' => __('material_icons.coordinator'),
                'text' => __('attrs.coordinator'),
                'secondaryText' => $program->coordinator
                    ->member
                    ->user
                    ->name,
            ],
        ]
    ]) @endlistTwoLine
@endcard

@can('updateRequests', \Modules\Project\Entities\Program::class)
    {{-- Ao tentar aprovar --}}
    @form([
        'method' => 'put',
        'action' => url("program-requests/{$program->id}"),
    ])
        {{-- Diálogo --}}
        @dialog([
            'activation' => "dialog-activation-approve-program-request-{$program->id}",
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
                'id' => "dialog-approve-program-request-{$program->id}"
            ],
            'title' => __('messages.program_requests.dialog.approve_title')
        ])
            {{ __('messages.program_request.dialog.approve_body') }}
        @enddialog

    @endform

    {{-- Ao tentar remover --}}
    @form([
        'method' => 'delete',
        'action' => url("program-requests/{$program->id}"),
    ])
        {{-- Diálogo --}}
        @dialog([
            'activation' => "dialog-activation-deny-program-request-{$program->id}",
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
                'id' => "dialog-deny-program-request-{$program->id}"
            ],
            'title' => __('messages.program_requests.dialog.deny_title')
        ])
            {{ __('messages.program_requests.dialog.deny_body') }}
        @enddialog
    @endform
@endcan