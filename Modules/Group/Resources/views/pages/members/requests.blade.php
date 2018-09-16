@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.groups'),
        $group->name,
        __('resources.members_requests'),
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
                'tabActive' => 'members',
            ]) @endheadingGroup
        @endcell
        
        {{-- Voltar --}}
        @cell
            @button([
                'isLink' => true,
                'icon' => __('icons.back'),
                'text' => __('actions.back'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/members")
                ]
            ]) @endbutton
        @endcell
        
        {{-- Ações em massa --}}
        @cell([
            'classes' => ['mdc-layout-grid--align-right']
        ])
            @dialogContainer([
                'button' => [
                    'icon' => __('icons.approve'),
                    'text' => __('actions.approve_all'),
                    'classes' => ['mdc-button--outlined']
                ],
                'form' => [
                    'action' => url("groups/{$group->id}/members/requests"),
                    'method' => 'put'
                ],
                'dialog' => [
                    'title' => __('dialogs.members_requests.approve_all_title', [
                        'count' => $members->count()
                    ]),
                    'text' => __('dialogs.members_requests.approve_all_body'),
                    'attrs' => [
                        'id' => 'dialog-group-members-requests-approve-all'
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
                        ],                        
                    ]
                ]
            ]) @enddialogContainer

            @dialogContainer([
                'button' => [
                    'icon' => __('icons.deny'),
                    'text' => __('actions.deny_all'),
                ],
                'form' => [
                    'action' => url("groups/{$group->id}/members/requests"),
                    'method' => 'delete'
                ],
                'dialog' => [
                    'title' => __('dialogs.members_requests.deny_all_title', [
                        'count' => $members->count()
                    ]),
                    'attrs' => [
                        'id' => 'dialog-group-members-requests-deny-all'
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
                        ],                        
                    ]
                ]
            ]) @enddialogContainer            
        @endcell

        {{-- Paginável --}}
        @cell
            @list([
                'twoLine' => true,
                'nonInteractive' => true,
                'items' => $members->map(function ($member) use ($group) {
                    return [
                        'icon' => __('icons.member'),
                        'text' => [
                            'link' => url("members/{$member->user_id}"),
                            'primary' => $member->user->name,
                            'secondary' => $member->created_at
                                ->diffForHumans(),
                        ],
                        'metas' => [
                            [
                                'dialogContainer' => [
                                    'iconButton' => [
                                        'icon' => __('icons.approve')
                                    ],
                                    'form' => [
                                        'action' => url("groups/{$group->id}/members/requests/{$member->user_id}"),
                                        'method' => 'put'
                                    ],
                                    'dialog' => [
                                        'attrs' => [
                                            'id' => "dialog-group-member-request-approve-{$member->user_id}"
                                        ],
                                        'title' => __('dialogs.members_requests.approve_title'),
                                        'text' => __('dialogs.members_requests.approve_body', [
                                            'name' => $member->user->name ?? null
                                        ]),
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
                                            ],                      
                                        ]
                                    ]
                                ]
                            ],
                            [
                                'dialogContainer' => [
                                    'iconButton' => [
                                        'icon' => __('icons.deny')
                                    ],
                                    'form' => [
                                        'action' => url("groups/{$group->id}/members/requests/{$member->user_id}"),
                                        'method' => 'delete'
                                    ],
                                    'dialog' => [
                                        'attrs' => [
                                            'id' => "dialog-group-member-request-deny-{$member->user_id}"
                                        ],
                                        'title' => __('dialogs.members_requests.deny_title'),
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
                                            ],                      
                                        ]
                                    ]
                                ]
                            ],

                        ]
                    ];
                }),
            ]) @endlist
        @endcell
    @endgridWithInner
@endsection
