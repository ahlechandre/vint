@heading([
    'pretitle' => __('resources.publications'),
    'title' => __("messages.publications.name", [
        'id' => $publication->id
    ]),
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'about',
                'label' => __('headlines.about'),
                'attrs' => [
                    'href' => url("publications/{$publication->id}")
                ]
            ],
            [
                'active' => $tabActive === 'projects',
                'label' => __('resources.projects'),
                'attrs' => [
                    'href' => url("publications/{$publication->id}/projects")
                ]
            ],
            [
                'active' => $tabActive === 'members',
                'label' => __('resources.members'),
                'attrs' => [
                    'href' => url("publications/{$publication->id}/members")
                ]
            ],            
        ]               
    ]
]) @endheading