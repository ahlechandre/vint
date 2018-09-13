@topAppBar([
    'classes' => [
        'mdc-elevation--z3',
        'top-app-bar--with-search',
        isset($searchVisible) && $searchVisible ?
            'top-app-bar--with-search-visible' : '',        
    ],
    'attrs' => [
        'data-vint-auto-init' => 'VintTopAppBarWithSearch'
    ],
    'rows' => [
        [
            'sections' => [
                [
                    'classes' => ['mdc-top-app-bar__section--align-start'],
                    'menu' => $menu ?? false,
                    'title' => $title ?? false
                ],
                [
                    'classes' => ['mdc-top-app-bar__section--align-end'],
                    'attrs' => ['role' => 'toolbar'],
                    'actions' => [
                        [
                            'icon' => 'search',
                            'classes' => [
                                'material-icons',
                                'top-app-bar__open-search'
                            ],
                            'attrs' => [
                                'href' => '#',
                                'title' => 'buscar'
                            ]
                        ],
                        [
                            'icon' => 'more_vert',
                            'classes' => [
                                'material-icons',
                            ],
                            'attrs' => [
                                'href' => '#',
                                'title' => __('headlines.options')
                            ]
                        ]                        
                    ]
                ]                
            ]          
        ],
        [
            'classes' => ['top-app-bar__row--search'],
            'sections' => [
                [
                    'classes' => [
                        'mdc-top-app-bar__section--align-start',
                        'top-app-bar__section--text-field'
                    ],
                    'attrs' => ['role' => 'toolbar'],
                    'component' => [
                        'view' => 'components.top-app-bar.top-app-bar-search-field',
                    ]
                ],             
                [
                    'classes' => ['mdc-top-app-bar__section--align-end'],
                    'attrs' => ['role' => 'toolbar'],
                    'actions' => [
                        [
                            'icon' => 'close',
                            'classes' => [
                                'material-icons',
                                'top-app-bar__close-search'
                            ],
                            'attrs' => [
                                'href' => '#',
                                'title' => __('actions.close')
                            ]
                        ]
                    ]
                ]                        
            ]          
        ],        
    ]
]) @endtopAppBar