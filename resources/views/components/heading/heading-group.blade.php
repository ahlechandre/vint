@heading([
    'pretitle' => __('resources.groups'),
    'title' => $group->name,
    'action' => auth()->check() && $user->isMember() ?
        [
            'dialogContainer' => [
                'button' => [
                    'text' => __('actions.request_participate'),
                    'classes' => ['mdc-button--outlined']
                ],
                'dialog' => [
                    'attrs' => [
                        'id' => 'dialog-group-request',
                    ], 
                    'title' => __('messages.groups.dialogs.request_participate_group'),
                    'footer' => [
                        'buttonAccept' => [
                            'text' => __('actions.confirm'),
                            'attrs' => [
                                'type' => 'button'
                            ],
                        ],
                        'buttonCancel' => [
                            'text' => __('actions.cancel'),
                            'attrs' => [
                                'type' => 'button'
                            ],
                        ],                                
                    ]                        
                ]                        
            ]
        ] : null,
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'about',
                'label' => __('headlines.about'),
                'attrs' => [
                    'href' => url("groups/{$group->id}")
                ]
            ],
            [
                'active' => $tabActive === 'coordinators',
                'label' => __('resources.coordinators'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/coordinators")
                ]
            ],                        
            [
                'active' => $tabActive === 'programs',
                'label' => __('resources.programs'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/programs")
                ]
            ],
            [
                'active' => $tabActive === 'projects',
                'label' => __('resources.projects'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/projects")
                ]
            ],
            [
                'active' => $tabActive === 'members',
                'label' => __('resources.members'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/members")
                ]
            ],    
        ]               
    ]
]) @endheading