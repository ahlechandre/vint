@card([
    'title' => $member->user->name,
    'subtitle' => $member->created_at
        ->diffForHumans(),
    'actions' => [
        [
            'type' => 'button',
            'props' => [
                'text' => __('actions.approve'),
                'icon' => __('material_icons.approve'),
                'attrs' => [
                    'disabled' => $user->cant('approve', \Modules\Group\Entities\Member::class),
                    'id' => "dialog-activation-approve-member-request-{$member->user_id}",
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
                    'disabled' => $user->cant('deny', \Modules\Group\Entities\Member::class),
                    'id' => "dialog-activation-deny-member-request-{$member->user_id}",
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
                'icon' => __("material_icons.{$member->role->slug}"),
                'text' => __('resources.role'),
                'secondaryText' => $member->role->name,
            ],
            [
                'icon' => __('material_icons.email'),
                'text' => __('attrs.email'),
                'secondaryText' => $member->user->email,
            ],
            [
                'icon' => __('material_icons.' . (
                    $member->isStudent() ?
                        'rga' : (
                            $member->isServant() ? 'siape' : 'cpf'
                        )
                )),
                'text' => __('attrs.' . (
                    $member->isStudent() ?
                        'rga' : (
                            $member->isServant() ? 'siape' : 'cpf'
                        )
                )),
                'secondaryText' => (
                    $member->isStudent() ?
                        $member->student->rga : (
                            $member->isServant() ?
                                $member->servant->siape : $member->cpf
                        )
                ),
            ]
        ]
    ]) @endlistTwoLine
@endcard

@can('approve', \Modules\Group\Entities\Member::class)
    {{-- Ao tentar aprovar --}}
    @form([
        'method' => 'put',
        'action' => url("member-requests/{$member->user_id}"),
    ])
        {{-- Diálogo --}}
        @dialog([
            'activation' => "dialog-activation-approve-member-request-{$member->user_id}",
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
                'id' => "dialog-approve-member-request-{$member->user_id}"
            ],
            'title' => __('messages.member_requests.dialog.approve_title')
        ])
            {{ __('messages.member_request.dialog.approve_body') }}
        @enddialog

    @endform
@endcan

@can('deny', \Modules\Group\Entities\Member::class)
    {{-- Ao tentar remover --}}
    @form([
        'method' => 'delete',
        'action' => url("member-requests/{$member->user_id}"),
    ])
        {{-- Diálogo --}}
        @dialog([
            'activation' => "dialog-activation-deny-member-request-{$member->user_id}",
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
                'id' => "dialog-deny-member-request-{$member->user_id}"
            ],
            'title' => __('messages.member_requests.dialog.deny_title')
        ])
            {{ __('messages.member_requests.dialog.deny_body') }}
        @enddialog
    @endform
@endcan