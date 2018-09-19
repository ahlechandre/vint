@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'withoutAnimation' => true,
    'title' => get_breadcrumb([
        __('resources.groups'),
        $group->name,
        __('resources.coordinators'),
    ])
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
            @paginable([
                'paginator' => $coordinators,
                'list' => [
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
                                    'ignore' => !$user || $user->cant('updateCoordinators', $group),
                                    'dialogContainer' => [
                                        'iconButton' => [
                                            'icon' => __('icons.edit'),
                                        ],
                                        'form' => [
                                            'action' => url("groups/{$group->id}/coordinators/{$coordinator->member_user_id}"),
                                            'method' => 'put'
                                        ],
                                        'dialog' => [
                                            'title' => __('dialogs.coordinators.edit_title'),
                                            'attrs' => [
                                                'id' => "dialog-coordinators-edit-{$coordinator->member_user_id}"
                                            ],
                                            'component' => [
                                                'view' => 'group::inputs.coordinator-edit',
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
                                    'ignore' => !$user || $user->cant('deleteCoordinators', $group),
                                    'dialogContainer' => [
                                        'iconButton' => [
                                            'icon' => __('icons.remove'),
                                        ],
                                        'form' => [
                                            'action' => url("groups/{$group->id}/coordinators/{$coordinator->member_user_id}"),
                                            'method' => 'delete'
                                        ],
                                        'dialog' => [
                                            'title' => __('dialogs.coordinators.remove_title'),
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
                ]
            ]) @endpaginable
            {{-- Novo --}}
            @can('createCoordinators', $group)
                @fabFixed([
                    'fab' => [
                        'icon' => __('icons.add'),
                        'classes' => ['dialog-activation'],
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
                        'title' => __('dialogs.coordinators.create_title'),
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
