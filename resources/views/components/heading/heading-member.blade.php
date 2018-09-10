@heading([
    'pretitle' => __('resources.members'),
    'title' => $member->user->name,
    'action' => auth()->check() && $user->can('update', $member->user) ?
        [
            'button' => [
                'isLink' => true,
                'icon' => __('icons.settings'),
                'text' => __('headlines.settings'),
                'attrs' => [
                    'href' => url('settings')
                ],
            ]
        ] : null,
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'about',
                'label' => __('headlines.about'),
                'attrs' => [
                    'href' => url("members/{$member->user_id}")
                ]
            ], 
            [
                'active' => $tabActive === 'groups',
                'label' => __('resources.groups'),
                'attrs' => [
                    'href' => url("members/{$member->user_id}/groups")
                ]
            ],            
            [
                'active' => $tabActive === 'programs',
                'ignore' => !$member->isServant(),
                'label' => __('resources.programs'),
                'attrs' => [
                    'href' => url("members/{$member->user_id}/programs")
                ]
            ],
            [
                'active' => $tabActive === 'projects',
                'label' => __('resources.projects'),
                'attrs' => [
                    'href' => url("members/{$member->user_id}/projects")
                ]
            ],
            [
                'active' => $tabActive === 'publications',
                'label' => __('resources.publications'),
                'attrs' => [
                    'href' => url("members/{$member->user_id}/publications")
                ]
            ],
        ]
    ]
]) @endheading