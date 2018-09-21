@extends('layouts.master', [
    'title' => __('headlines.dashboard')
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => [
                'layout-grid--large',
                'layout-grid--padding-top'                                
            ]
        ]
    ])
        {{-- Contador / grupos --}}
        @cell([
            'when' => ['d' => 2, 't' => 4, 'p' => 2]
        ])
            @count([
                'value' => $counts['groups'],
                'title' => __('resources.groups'),
                'icon' => __('icons.groups'),
            ]) @endcount
        @endcell

        {{-- Contador / membros --}}
        @cell([
            'when' => ['d' => 2, 't' => 4, 'p' => 2]
        ])
            @count([
                'value' => $counts['members'],
                'title' => __('resources.members'),
                'icon' => __('icons.members'),
            ]) @endcount
        @endcell
        
        {{-- Contador / programas --}}
        @cell([
            'when' => ['d' => 2, 't' => 4, 'p' => 2]
        ])
            @count([
                'value' => $counts['programs'],
                'title' => __('resources.programs'),
                'icon' => __('icons.programs'),
            ]) @endcount
        @endcell
        
        {{-- Contador / projetos --}}
        @cell([
            'when' => ['d' => 2, 't' => 4, 'p' => 2]
        ])
            @count([
                'value' => $counts['projects'],
                'title' => __('resources.projects'),
                'icon' => __('icons.projects'),
            ]) @endcount
        @endcell

        {{-- Contador / produtos --}}
        @cell([
            'when' => ['d' => 2, 't' => 4, 'p' => 2]
        ])
            @count([
                'value' => $counts['products'],
                'title' => __('resources.products'),
                'icon' => __('icons.products'),
            ]) @endcount
        @endcell

        {{-- Contador / publicações --}}
        @cell([
            'when' => ['d' => 2, 't' => 4, 'p' => 2]
        ])
            @count([
                'value' => $counts['publications'],
                'title' => __('resources.publications'),
                'icon' => __('icons.publications'),
            ]) @endcount
        @endcell

        {{-- Últimos grupos --}}
        @cell([
            'when' => ['d' => 4, 't' => 4, 'p' => 4]
        ])
            @card([
                'classes' => [
                    'card--with-list',
                    'mdc-card--outlined'
                ],
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'icon' => __('icons.forward'),
                            'text' => __('actions.explore'),
                            'attrs' => [
                                'title' => __('messages.groups.index'),
                                'href' => url('groups'),
                            ]
                        ], 
                        [
                            'isLink' => $user->can('create', \Modules\Group\Entities\Group::class),
                            'icon' => __('icons.add'),
                            'text' => __('actions.new'),
                            'attrs' => [
                                'title' => __('messages.groups.create'),
                                'href' => url('groups/create'),
                                'disabled' => $user->cant('create', \Modules\Group\Entities\Group::class)
                            ]
                        ],
                    ]
                ]
            ])
                @cardHeader([
                    'title' => __('messages.dashboard.latest_groups'),
                ]) @endcardHeader

                @cardContent
                    @paginableGroups([
                        'withoutSearch' => true,
                        'withoutActions' => true,
                        'groups' => $groups
                    ]) @endpaginableGroups                    
                @endcardContent
            @endcard
        @endcell

        {{-- Últimos membros --}}
        @cell([
            'when' => ['d' => 4, 't' => 4, 'p' => 4]
        ])
            @card([
                'classes' => [
                    'card--with-list',
                    'mdc-card--outlined'
                ],
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'icon' => __('icons.forward'),
                            'text' => __('actions.explore'),
                            'attrs' => [
                                'title' => __('messages.members.index'),
                                'href' => url('members'),
                            ]
                        ]
                    ]
                ]                    
            ])
                @cardHeader([
                    'title' => __('messages.dashboard.latest_members'),
                ]) @endcardHeader

                @cardContent
                    @paginableMembers([
                        'withoutSearch' => true,
                        'withoutActions' => true,
                        'members' => $members
                    ]) @endpaginableMembers         
                @endcardContent
            @endcard
        @endcell

        {{-- Últimos programas --}}
        @cell([
            'when' => ['d' => 4, 't' => 4, 'p' => 4]
        ])
            @card([
                'classes' => [
                    'card--with-list',
                    'mdc-card--outlined'
                ],
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'icon' => __('icons.forward'),
                            'text' => __('actions.explore'),
                            'attrs' => [
                                'title' => __('messages.programs.index'),
                                'href' => url('programs'),
                            ]
                        ], 
                    ]
                ]                    
            ])
                @cardHeader([
                    'title' => __('messages.dashboard.latest_programs'),
                ]) @endcardHeader

                @cardContent
                    @paginablePrograms([
                        'withoutSearch' => true,
                        'withoutActions' => true,
                        'programs' => $programs
                    ]) @endpaginablePrograms         
                @endcardContent
            @endcard
        @endcell

        {{-- Últimos projetos --}}
        @cell([
            'when' => ['d' => 4, 't' => 4, 'p' => 4]
        ])
            @card([
                'classes' => [
                    'card--with-list',
                    'mdc-card--outlined'
                ],
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'icon' => __('icons.forward'),
                            'text' => __('actions.explore'),
                            'attrs' => [
                                'title' => __('messages.projects.index'),
                                'href' => url('projects'),
                            ]
                        ], 
                    ]
                ]                    
            ])
                @cardHeader([
                    'title' => __('messages.dashboard.latest_projects'),
                ]) @endcardHeader

                @cardContent
                    @paginableProjects([
                        'withoutSearch' => true,
                        'withoutActions' => true,
                        'projects' => $projects
                    ]) @endpaginableProjects         
                @endcardContent
            @endcard
        @endcell

        {{-- Últimos produtos --}}
        @cell([
            'when' => ['d' => 4, 't' => 4, 'p' => 4]
        ])
            @card([
                'classes' => [
                    'card--with-list',
                    'mdc-card--outlined'
                ],
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'icon' => __('icons.forward'),
                            'text' => __('actions.explore'),
                            'attrs' => [
                                'title' => __('messages.products.index'),
                                'href' => url('products'),
                            ]
                        ], 
                        [
                            'isLink' => true,
                            'icon' => __('icons.add'),
                            'text' => __('actions.new'),
                            'attrs' => [
                                'title' => __('messages.products.create'),
                                'href' => url('products/create'),
                            ]
                        ],
                    ]
                ]                    
            ])
                @cardHeader([
                    'title' => __('messages.dashboard.latest_products'),
                ]) @endcardHeader

                @cardContent
                    @paginableProducts([
                        'withoutSearch' => true,
                        'withoutActions' => true,
                        'products' => $products
                    ]) @endpaginableProducts         
                @endcardContent
            @endcard
        @endcell

        {{-- Últimas publicações --}}
        @cell([
            'when' => ['d' => 4, 't' => 4, 'p' => 4]
        ])
            @card([
                'classes' => [
                    'card--with-list',
                    'mdc-card--outlined'
                ],
                'actions' => [
                    'buttons' => [
                        [
                            'isLink' => true,
                            'icon' => __('icons.forward'),
                            'text' => __('actions.explore'),
                            'attrs' => [
                                'title' => __('messages.publications.index'),
                                'href' => url('publications'),
                            ]
                        ], 
                        [
                            'isLink' => true,
                            'icon' => __('icons.add'),
                            'text' => __('actions.new'),
                            'attrs' => [
                                'title' => __('messages.publications.create'),
                                'href' => url('publications/create'),
                            ]
                        ],
                    ]
                ]                    
            ])
                @cardHeader([
                    'title' => __('messages.dashboard.latest_publications'),
                ]) @endcardHeader

                @cardContent
                    @paginablePublications([
                        'withoutSearch' => true,
                        'withoutActions' => true,
                        'publications' => $publications
                    ]) @endpaginablePublications         
                @endcardContent
            @endcard
        @endcell

    @endgridWithInner
@endsection