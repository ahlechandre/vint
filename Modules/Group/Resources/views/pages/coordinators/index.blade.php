@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.groups').' / '.$group->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingGroup([
                'group' => $group,
                'tabActive' => 'coordinators',
            ]) @endheadingGroup
        @endcell
        
        {{-- Paginável --}}
        @cell
            @list([
                'twoLine' => true,
                'nonInteractive' => true,
                'items' => $coordinators->map(function ($coordinator) use ($user, $group) {
                    return [
                        'icon' => __('icons.coordinator'),
                        'text' => [
                            'link' => url("members/{$coordinator->member_user_id}"),
                            'primary' => $coordinator->member
                                ->user
                                ->name,
                            'secondary' => $coordinator->created_at
                                ->diffForHumans(),
                        ],
                        'metas' => [
                            [
                                'ignore' => $user->cant('updateCoordinators', $group),
                                'dialogContainer' => [
                                    'iconButton' => [
                                        'icon' => __('icons.edit'),
                                    ],
                                    'form' => [
                                        'action' => url("groups/{$group->id}/coordinators/{$coordinator->member_user_id}"),
                                        'method' => 'put'
                                    ],
                                    'dialog' => [
                                        'title' => __('messages.coordinators.dialogs.update_title'),
                                        'attrs' => [
                                            'id' => "dialog-coordinators-edit-{$coordinator->member_user_id}"
                                        ],
                                        'component' => [
                                            'view' => 'group::inputs.coordinator-update',
                                            'props' => [
                                                'coordinator' => $coordinator
                                            ],
                                        ],
                                        'footer' => [
                                            'buttonAccept' => [
                                                'text' => __('actions.update'),
                                                'attrs' => [
                                                    'type' => 'submit'
                                                ]
                                            ],
                                            'buttonCancel' => [
                                                'text' => __('actions.cancel'),
                                                'attrs' => [
                                                    'type' => 'button'
                                                ]
                                            ]                        
                                        ]
                                    ]
                                ],
                            ],                            
                            [
                                'ignore' => $user->cant('deleteCoordinators', $group),
                                'dialogContainer' => [
                                    'iconButton' => [
                                        'icon' => __('icons.delete'),
                                    ],
                                    'form' => [
                                        'action' => url("groups/{$group->id}/coordinators/{$coordinator->member_user_id}"),
                                        'method' => 'delete'
                                    ],
                                    'dialog' => [
                                        'title' => __('messages.coordinators.dialogs.delete_title'),
                                        'attrs' => [
                                            'id' => "dialog-coordinators-delete-{$coordinator->member_user_id}"
                                        ],
                                        'footer' => [
                                            'buttonAccept' => [
                                                'text' => __('actions.confirm'),
                                                'attrs' => [
                                                    'type' => 'submit'
                                                ]
                                            ],
                                            'buttonCancel' => [
                                                'text' => __('actions.cancel'),
                                                'attrs' => [
                                                    'type' => 'button'
                                                ]
                                            ]                        
                                        ]
                                    ]
                                ],
                            ],                            
                            [
                                'iconButton' => [
                                    'isLink' => true, 
                                    'icon' => __('icons.show'),
                                    'attrs' => [
                                        'href' => url("members/{$coordinator->member_user_id}")
                                    ]
                                ]
                            ]
                        ],
                    ];
                }),                
            ])
            @endlist

            {{-- Novo --}}
            @can('createCoordinators', $group)
                @fabFixed([
                    'fab' => [
                        'icon' => __('icons.add'),
                        'classes' => [
                            'mdc-fab--extended',
                            'dialog-activation'
                        ],
                        'label' => __('actions.new'),
                        'attrs' => [
                            'title' => __('messages.groups.coordinators.create'),
                            'data-dialog-activation' => 'dialog-coordinators-create',
                            'data-vint-auto-init' => 'VintDialogActivation'
                        ],
                    ]
                ]) @endfabFixed

                @form([
                    'action' => url("groups/{$group->id}/coordinators"),
                    'method' => 'post'
                ])
                    @dialog([
                        'title' => __('messages.coordinators.dialogs.create_title'),
                        'attrs' => [
                            'id' => 'dialog-coordinators-create'
                        ],
                        'component' => [
                            'view' => 'group::inputs.coordinator-create',
                            'props' => [
                                'servantMembers' => $servantMembers
                            ],
                        ],
                        'footer' => [
                            'buttonAccept' => [
                                'text' => __('actions.create'),
                                'attrs' => [
                                    'type' => 'submit'
                                ]
                            ],
                            'buttonCancel' => [
                                'text' => __('actions.cancel'),
                                'attrs' => [
                                    'type' => 'button'
                                ]
                            ]                        
                        ]
                    ]) @enddialog                
                @endform
            @endcan
        @endcell
    @endgridWithInner
@endsection
