@heading([
    'pretitle' => __('headlines.search'),
    'title' => "\"{$term}\"",
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'all',
                'label' => __('headlines.all'),
                'attrs' => [
                    'href' => url("search?q={$term}")
                ]
            ],
            [
                'active' => $tabActive === 'members',
                'label' => __('resources.members'),
                'attrs' => [
                    'href' => url("search/members?q={$term}")
                ]
            ],
            [
                'active' => $tabActive === 'groups',
                'label' => __('resources.groups'),
                'attrs' => [
                    'href' => url("search/groups?q={$term}")
                ]
            ],
            [
                'active' => $tabActive === 'programs',
                'label' => __('resources.programs'),
                'attrs' => [
                    'href' => url("search/programs?q={$term}")
                ]
            ],
            [
                'active' => $tabActive === 'projects',
                'label' => __('resources.projects'),
                'attrs' => [
                    'href' => url("search/projects?q={$term}")
                ]
            ],
            [
                'active' => $tabActive === 'products',
                'label' => __('resources.products'),
                'attrs' => [
                    'href' => url("search/products?q={$term}")
                ]
            ],
            [
                'active' => $tabActive === 'publications',
                'label' => __('resources.publications'),
                'attrs' => [
                    'href' => url("search/publications?q={$term}")
                ]
            ],
        ]
    ]
]) @endheading