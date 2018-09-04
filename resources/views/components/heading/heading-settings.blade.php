@heading([
    'pretitle' => __('headlines.settings'),
    'title' => $userToEdit->name,
    'tabBar' => [
        'tabs' => [
            [
                'active' => $active === 'general',
                'label' => __('headlines.general'),
                'attrs' => [
                    'href' => request()->fullUrlWithQuery([
                        'section' => 'general'
                    ])
                ]
            ],
            [
                'active' => $active === 'member',
                'label' => __('resources.member'),
                'ignore' => !$userToEdit->isMember(),
                'attrs' => [
                    'href' => request()->fullUrlWithQuery([
                        'section' => 'member'
                    ])
                ]
            ],
            [
                'active' => $active === 'security',
                'label' => __('headlines.security'),
                'attrs' => [
                    'href' => request()->fullUrlWithQuery([
                        'section' => 'security'
                    ])
                ]
            ],
        ]                    
    ]
]) @endheading