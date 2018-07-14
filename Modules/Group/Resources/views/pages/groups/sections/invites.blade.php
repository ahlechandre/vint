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
                'items' => $group->invites->map(function ($invite, $index) {
                    return [
                        'icon' => __('material_icons.invite'), 
                        'text' => __('resources.invite') . ' #' . ($index + 1), 
                        'secondaryText' => $invite->id,
                        'metas' => [
                            [
                                'icon' => 'edit',
                                'attrs' => [
                                    'href' => '#',
                                    'title' => __('actions.edit'),
                                    'id' => "dialog-activation-edit-invite-{$invite->id}"
                                ],
                            ],
                            [
                                'icon' => 'close',
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
<form action="{{ url("groups/{$group->id}/invites") }}" method="post">
    @csrf

    @dialog([
        'activation' => 'dialog-activation-create-invite',
        'title' => __('messages.invites.create'),
        'attrs' => [
            'id' => 'dialog-create-invite',
        ],
        'cancel' => [
            'text' => __('actions.cancel'),
            'attrs' => [],
        ],
        'accept' => [
            'text' => __('actions.create'),
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
                    {{ __('messages.invites.description') }}
                </p>
            @endcell

            {{-- Expira em --}}
            @cell([
                'when' => [
                    'desktop' => 6,
                    'tablet' => 8,
                ]
            ])
                @textfield([
                    'label' => __('attrs.expires_at'),
                    'attrs' => [
                        'type' => 'date',
                        'name' => 'expires_at',
                        'required' => '',
                        'value' => Carbon\Carbon::now()->addYears(1)
                            ->format('Y-m-d'),
                        'id' => 'textfield-group-invite-expires-at',
                    ],
                ]) @endtextfield
            @endcell

        @endlayoutGridInner
    @enddialog
</form>

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
