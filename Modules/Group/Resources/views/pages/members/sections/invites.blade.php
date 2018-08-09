@layoutGridWithInner([
    'modifiers' => ['layout-grid--dense']
])
    @cell([
        'when' => ['default' => 12]
    ])
        @card([
            'title' => __('resources.invites'),
            'subtitle' => __('messages.invites.index'),
            'modifiers' => ['mdc-card--outlined'],
        ])
            @listTwoLine([
                'items' => $group->invites
                    ->sortBy('expires_at')
                    ->map(function ($invite, $index) {
                    return [
                        'icon' => __('material_icons.invite'), 
                        'text' => __('attrs.expires_at') . ' ' . $invite->expires_at->diffForHumans(), 
                        'secondaryText' => $invite->url,
                        'metas' => [
                            [
                                'icon' => 'details',
                                'attrs' => [
                                    'href' => '#',
                                    'title' => __('actions.details'),
                                    'id' => "dialog-activation-details-invite-{$invite->id}"
                                ],
                            ],    
                            [
                                'icon' => 'edit',
                                'attrs' => [
                                    'href' => '#',
                                    'title' => __('actions.edit'),
                                    'id' => "dialog-activation-edit-invite-{$invite->id}"
                                ],
                            ],
                            [
                                'icon' => 'delete_outline',
                                'attrs' => [
                                    'href' => '#',
                                    'title' => __('actions.delete'),
                                    'id' => "dialog-activation-destroy-invite-{$invite->id}"
                                ],
                            ] 
                        ]
                    ];
                })
            ]) @endlistTwoLine
        @endcard
    
    @endcell
@endlayoutGridInner


{{-- Invite Create Dialog --}}
@form([
    'action' => url("groups/{$group->id}/invites"),
    'method' => 'post',
    'inputs' => [
        '__view' => 'group::inputs.invite',
        'props' => [
            'title' => __('messages.invites.create'),
            'description' => __('messages.invites.description_on_create'),
            'activation' => 'dialog-activation-create-invite',
            'dialogId' => 'dialog-create-invite',
            'acceptText' => __('actions.create'),
            'expiresAt' => Carbon\Carbon::now()
                ->addYears(1)
                ->format('Y-m-d')
        ]
    ]
]) @endform

{{-- Invite Edit Dialogs --}}
@foreach($group->invites as $invite)
    @form([
        'action' => url("groups/{$group->id}/invites/{$invite->id}"),
        'method' => 'put',
        'inputs' => [
            '__view' => 'group::inputs.invite',
            'props' => [
                'title' => __('messages.invites.edit'),
                'description' => __('messages.invites.description_on_edit'),
                'activation' => "dialog-activation-edit-invite-{$invite->id}",
                'dialogId' => "dialog-edit-invite-{$invite->id}",
                'acceptText' => __('actions.edit'),
                'expiresAt' => $invite->expires_at
                    ->format('Y-m-d')
            ]
        ]
    ]) @endform
@endforeach

{{-- Invite Destroy Dialogs --}}
@foreach($group->invites as $invite)
    @form([
        'action' => url("groups/{$group->id}/invites/{$invite->id}"),
        'method' => 'delete'
    ])
        @dialog([
            'activation' => "dialog-activation-destroy-invite-{$invite->id}",
            'title' => __('messages.invites.destroy'),
            'attrs' => [
                'id' => "dialog-destroy-invite-{$invite->id}",
            ],
            'cancel' => [
                'text' => __('actions.cancel'),
                'attrs' => [
                    'type' => 'button'
                ],
            ],
            'accept' => [
                'text' => __('actions.delete'),
                'attrs' => [
                    'type' => 'submit'
                ],
            ],        
        ])
            @layoutGridInner
                {{-- Descrição --}}
                @cell([
                    'when' => [
                        'desktop' => 12,
                        'tablet' => 8,
                    ]
                ])
                    <p class="mdc-typography--subtitle1">
                        {{ __('messages.invites.description_on_destroy') }}
                    </p>
                @endcell
            @endlayoutGridInner
        @enddialog  
    @endform
@endforeach

{{-- Invite Details Dialogs --}}
@foreach($group->invites as $invite)
    @dialog([
        'activation' => "dialog-activation-details-invite-{$invite->id}",
        'title' => __('messages.invites.details'),
        'attrs' => [
            'id' => "dialog-details-invite-{$invite->id}",
        ],
        'accept' => [
            'text' => __('actions.ok'),
            'attrs' => [
                'type' => 'button'
            ],
        ],
    ])
        @layoutGridInner
            {{-- Descrição --}}
            @cell([
                'when' => [
                    'desktop' => 12,
                    'tablet' => 8,
                ]
            ])
                @listTwoLine([
                    'items' => [
                        [
                            'icon' => __('material_icons.user'),
                            'text' => __('attrs.creator'),
                            'secondaryText' => $invite->user->name,
                        ],
                        [
                            'icon' => __('material_icons.expires_at'),
                            'text' => __('attrs.expires_at'),
                            'secondaryText' => $invite->expires_at
                                ->format('d/m/Y à\s H:i'),
                        ],
                        [
                            'icon' => __('material_icons.created_at'),
                            'text' => __('attrs.created_at'),
                            'secondaryText' => $invite->created_at
                                ->format('d/m/Y à\s H:i'),
                        ],
                        [
                            'icon' => __('material_icons.updated_at'),
                            'text' => __('attrs.updated_at'),
                            'secondaryText' => $invite->updated_at
                                ->format('d/m/Y à\s H:i'),
                        ]
                    ]
                ]) @endlistTwoLine
            @endcell
        @endlayoutGridInner
    @enddialog  
@endforeach

@fab([
    'icon' => 'add',
    'label' => __('messages.invites.new'),
    'modifiers' => ['fab--fixed'],
    'attrs' => [
        'id' => 'dialog-activation-create-invite',
        'title' => __('messages.invites.new'),
        'alt' => __('messages.invites.new'),
    ],
]) @endfab
