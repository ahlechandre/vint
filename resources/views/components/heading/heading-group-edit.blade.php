@heading([
    'pretitle' => __('resources.groups'),
    'title' => $group->name,
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'general',
                'label' => __('headlines.general'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/edit")
                ]
            ], 
            [
                'active' => $tabActive === 'permissions',
                'label' => __('resources.permissions'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/edit?section=permissions")
                ]
            ],
        ]
    ]
]) @endheading