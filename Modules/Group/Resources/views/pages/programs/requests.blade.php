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
                'tabActive' => 'programs',
            ]) @endheadingGroup
        @endcell
        
        {{-- Voltar --}}
        @cell
            @button([
                'isLink' => true,
                'icon' => __('icons.back'),
                'text' => __('actions.back'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/programs")
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
                    'classes' => ['mdc-button--unelevated']
                ],
                'form' => [
                    'action' => url("groups/{$group->id}/programs-requests"),
                    'method' => 'put'
                ],
                'dialog' => [
                    'title' => __('messages.groups.programs.dialogs.approve_all_title'),
                    'attrs' => [
                        'id' => 'dialog-group-programs-requests-approve-all'
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
                    'action' => url("groups/{$group->id}/programs-requests"),
                    'method' => 'delete'
                ],
                'dialog' => [
                    'title' => __('messages.groups.programs.dialogs.deny_all_title'),
                    'attrs' => [
                        'id' => 'dialog-group-programs-requests-deny-all'
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
                'items' => $programs->map(function ($program) use ($group) {
                    return [
                        'icon' => __('icons.program'),
                        'text' => [
                            'link' => url("members/{$program->id}"),
                            'primary' => $program->name,
                            'secondary' => $program->created_at
                                ->diffForHumans(),
                        ],
                        'metas' => [
                            [
                                'dialogContainer' => [
                                    'iconButton' => [
                                        'icon' => __('icons.approve')
                                    ],
                                    'form' => [
                                        'action' => url("groups/{$group->id}/programs-requests/{$program->id}"),
                                        'method' => 'put'
                                    ],
                                    'dialog' => [
                                        'attrs' => [
                                            'id' => "dialog-group-program-request-approve-{$program->id}"
                                        ],
                                        'title' => __('messages.groups.programs.dialogs.approve'),
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
                                        'action' => url("groups/{$group->id}/programs-requests/{$program->id}"),
                                        'method' => 'delete'
                                    ],
                                    'dialog' => [
                                        'attrs' => [
                                            'id' => "dialog-group-program-request-deny-{$program->id}"
                                        ],
                                        'title' => __('messages.groups.programs.dialogs.deny'),
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
