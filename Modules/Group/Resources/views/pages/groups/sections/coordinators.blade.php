@layoutGridWithInner([
    'modifiers' => ['layout-grid--dense']
])
    @cell([
        'when' => ['default' => 12]
    ])
        @card([
            'title' => __('resources.coordinators'),
            'subtitle' => __('messages.coordinators.index'),
            'modifiers' => ['mdc-card--outlined'],
        ])
            @listTwoLine([
                'items' => $group->coordinators
                    ->load('member.user')
                    ->map(function ($coordinator) {
                        return [
                            'icon' => __('material_icons.coordinator'), 
                            'text' => $coordinator->member->user->name, 
                            'secondaryText' => $coordinator->pivot->is_vice ? 'Vice coordenador' : 'Coordenador principal',
                            'metas' => [
                                [
                                    'icon' => 'edit',
                                    'attrs' => [
                                        'href' => '#',
                                        'title' => __('actions.edit'),
                                        'id' => "dialog-activation-edit-coordinator-{$coordinator->member_user_id}"
                                    ],
                                ],
                                [
                                    'icon' => 'close',
                                    'attrs' => [
                                        'href' => '#',
                                        'title' => __('actions.delete'),
                                        'id' => "dialog-activation-destroy-coordinator-{$coordinator->member_user_id}"
                                    ],
                                ] 
                            ]
                        ];
                    })
            ]) @endlistTwoLine
        @endcard
    
    @endcell
@endlayoutGridInner


{{-- Coordinator Create Dialog --}}
@form([
    'action' => url("groups/{$group->id}/coordinators"),
    'method' => 'post',
    'inputs' => [
        'view' => 'group::dialogs.coordinators.create',
        'props' => [
            'title' => __('messages.coordinators.create'),
            'description' => __('messages.coordinators.description_on_create'),
            'activation' => 'dialog-activation-create-coordinator',
            'dialogId' => 'dialog-create-coordinator',
            'acceptText' => __('actions.confirm'),
            'professors' => $professors,
        ]
    ]
]) @endform

{{-- Coordinator Edit Dialogs --}}
@foreach($group->coordinators as $coordinator)
    @form([
        'action' => url("groups/{$group->id}/coordinators/{$coordinator->member_user_id}"),
        'method' => 'put',
        'inputs' => [
            'view' => 'group::dialogs.coordinators.update',
            'props' => [
                'title' => __('messages.coordinators.edit'),
                'description' => __('messages.coordinators.description_on_edit'),
                'activation' => "dialog-activation-edit-coordinator-{$coordinator->member_user_id}",
                'dialogId' => "dialog-edit-coordinator-{$coordinator->member_user_id}",
                'acceptText' => __('actions.edit'),
                'coordinator' => $coordinator,
            ]
        ]
    ]) @endform
@endforeach

{{-- Coordinator Destroy Dialogs --}}
@foreach($group->coordinators as $coordinator)
    @form([
        'action' => url("groups/{$group->id}/coordinators/{$coordinator->member_user_id}"),
        'method' => 'delete'
    ])
        @dialog([
            'activation' => "dialog-activation-destroy-coordinator-{$coordinator->member_user_id}",
            'title' => __('messages.coordinator.destroy'),
            'attrs' => [
                'id' => "dialog-destroy-coordinator-{$coordinator->member_user_id}",
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
                        {{ __('messages.coordinators.description_on_destroy') }}
                    </p>
                @endcell
            @endlayoutGridInner
        @enddialog  
    @endform
@endforeach

@fab([
    'icon' => 'add',
    'label' => __('messages.coordinators.new'),
    'modifiers' => ['fab--fixed'],
    'attrs' => [
        'id' => 'dialog-activation-create-coordinator',
        'title' => __('messages.coordinators.new'),
        'alt' => __('messages.coordinators.new'),
    ],
]) @endfab
