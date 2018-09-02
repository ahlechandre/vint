@heading([
    'pretitle' => __('resources.programs'),
    'title' => $program->name,
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'about',
                'label' => __('headlines.about'),
                'attrs' => [
                    'href' => url("programs/{$program->id}")
                ]
            ], 
            [
                'active' => $tabActive === 'projects',
                'label' => __('resources.projects'),
                'attrs' => [
                    'href' => url("programs/{$program->id}/projects")
                ]
            ],
        ]
    ]
]) @endheading