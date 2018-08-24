@topAppBar([
    'classes' => ['mdc-elevation--z3'],
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
                            'classes' => ['material-icons'],
                            'attrs' => [
                                'href' => '#',
                                'title' => 'buscar'
                            ]
                        ]
                    ]
                ]                        
            ]          
        ],
    ]
]) @endtopAppBar