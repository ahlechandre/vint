@heading([
    'pretitle' => __('resources.groups'),
    'title' => $group->name,
    'action' => auth()->check() && $user->isMember() ?
        [
            'dialogContainer' => [
                'button' => $group->isMember($user->member) ?
                    (
                        $group->isApprovedMember($user->member) ?
                            [
                                'icon' => __('icons.leave_group'),
                                'text' => __('actions.leave_group'),
                                'classes' => ['mdc-button--outlined']
                            ] :
                            [
                                'icon' => __('icons.requested_group'),
                                'text' => __('actions.requested_group'),
                                'classes' => ['mdc-button--outlined']
                            ]
                    ) :
                    [
                        'icon' => __('icons.request_group'),
                        'text' => __('actions.request_group'),
                        'classes' => ['mdc-button--unelevated']
                    ],
                'form' => [
                    'action' => url("groups/{$group->id}/members/{$user->member->user_id}"),
                    'method' => 'put',
                ],
                'dialog' => [
                    'attrs' => [
                        'id' => 'dialog-group-request',
                    ], 
                    'title' => __('messages.members.dialogs.' . (
                        $group->isMember($user->member) ?
                            (
                                $group->isApprovedMember($user->member) ?
                                    'leave_group_title' :
                                    'requested_group_title'
                            ) :
                            'request_group_title'
                    )),
                    'footer' => [
                        'buttonAccept' => [
                            'text' => __('actions.confirm'),
                            'attrs' => [
                                'type' => 'submit'
                            ],
                        ],
                        'buttonCancel' => [
                            'text' => __('actions.cancel'),
                            'attrs' => [
                                'type' => 'button'
                            ],
                        ],                                
                    ]
                ],                        
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