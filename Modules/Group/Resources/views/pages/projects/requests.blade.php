@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'withoutAnimation' => true,
    'title' => get_breadcrumb([
        __('resources.groups'),
        $group->name,
        __('resources.projects_requests')
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
                'tabActive' => 'projects',
            ]) @endheadingGroup
        @endcell
        
        {{-- Voltar --}}
        @cell
            @button([
                'isLink' => true,
                'icon' => __('icons.back'),
                'text' => __('actions.back'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/projects")
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
                    'action' => url("groups/{$group->id}/projects/requests"),
                    'method' => 'put'
                ],
                'dialog' => [
                    'title' => __('dialogs.projects_requests.approve_all_title', [
                        'count' => $projects->count()
                    ]),
                    'text' => __('dialogs.projects_requests.approve_all_body'),
                    'attrs' => [
                        'id' => 'dialog-group-projects-requests-approve-all'
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
                    'action' => url("groups/{$group->id}/projects/requests"),
                    'method' => 'delete'
                ],
                'dialog' => [
                    'title' => __('dialogs.projects_requests.deny_all_title', [
                        'count' => $projects->count()
                    ]),
                    'attrs' => [
                        'id' => 'dialog-group-projects-requests-deny-all'
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
                'items' => $projects->map(function ($project) use ($group) {
                    return [
                        'icon' => __('icons.project'),
                        'text' => [
                            'link' => url("members/{$project->id}"),
                            'primary' => $project->name,
                            'secondary' => $project->created_at
                                ->diffForHumans(),
                        ],
                        'metas' => [
                            [
                                'dialogContainer' => [
                                    'iconButton' => [
                                        'icon' => __('icons.approve')
                                    ],
                                    'form' => [
                                        'action' => url("groups/{$group->id}/projects/requests/{$project->id}"),
                                        'method' => 'put'
                                    ],
                                    'dialog' => [
                                        'attrs' => [
                                            'id' => "dialog-group-project-request-approve-{$project->id}"
                                        ],
                                        'title' => __('dialogs.projects_requests.approve_title', [
                                            'name' => $project->name
                                        ]),
                                        'text' => __('dialogs.projects_requests.approve_body'),
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
                                        'action' => url("groups/{$group->id}/projects/requests/{$project->id}"),
                                        'method' => 'delete'
                                    ],
                                    'dialog' => [
                                        'attrs' => [
                                            'id' => "dialog-group-project-request-deny-{$project->id}"
                                        ],
                                        'title' => __('dialogs.projects_requests.deny_title', [
                                            'name' => $project->name
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
                        ]
                    ];
                }),
            ]) @endlist
        @endcell
    @endgridWithInner
@endsection
