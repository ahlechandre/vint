@heading([
    'pretitle' => __('resources.projects'),
    'title' => $project->name,
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'about',
                'label' => __('headlines.about'),
                'attrs' => [
                    'href' => url("projects/{$project->id}")
                ]
            ], 
            [
                'active' => $tabActive === 'students',
                'label' => __('resources.students'),
                'attrs' => [
                    'href' => url("projects/{$project->id}/students")
                ]
            ],
            [
                'active' => $tabActive === 'publications',
                'label' => __('resources.publications'),
                'attrs' => [
                    'href' => url("projects/{$project->id}/publications")
                ]
            ],
            [
                'active' => $tabActive === 'products',
                'label' => __('resources.products'),
                'attrs' => [
                    'href' => url("projects/{$project->id}/products")
                ]
            ],
        ]
    ]
]) @endheading