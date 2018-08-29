@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.groups').' / '.$group->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @heading([
                'pretitle' => __('resources.groups'),
                'title' => $group->name,
                'action' => [
                    'dialogContainer' => [
                        'button' => [
                            'text' => __('actions.request_participate'),
                            'classes' => ['mdc-button--outlined']
                        ],
                        'dialog' => [
                            'attrs' => [
                                'id' => 'dialog-group-request',
                            ], 
                            'title' => __('messages.groups.dialogs.request_participate_group'),
                            'footer' => [
                                'buttonAccept' => [
                                    'text' => __('actions.confirm'),
                                    'attrs' => [
                                        'type' => 'button'
                                    ],
                                ],
                                'buttonCancel' => [
                                    'text' => __('actions.cancel'),
                                    'attrs' => [
                                        'type' => 'button'
                                    ],
                                ],                                
                            ]                        
                        ]                        
                    ]
                ],
                'tabBar' => [
                    'tabs' => [
                        [
                            'active' => !$section,
                            'label' => __('headlines.about'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}")
                            ]
                        ],
                        [
                            'active' => $section === 'coordinators',
                            'label' => __('resources.coordinators'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}/coordinators")
                            ]
                        ],                        
                        [
                            'active' => $section === 'programs',
                            'label' => __('resources.programs'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}/programs")
                            ]
                        ],
                        [
                            'active' => $section === 'projects',
                            'label' => __('resources.projects'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}/projects")
                            ]
                        ],
                        [
                            'active' => $section === 'members',
                            'label' => __('resources.members'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}/members")
                            ]
                        ],
                        [
                            'active' => $section === 'products',
                            'label' => __('resources.products'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}/products")
                            ]
                        ],
                        [
                            'active' => $section === 'publications',
                            'label' => __('resources.publications'),
                            'attrs' => [
                                'href' => url("groups/{$group->id}/publications")
                            ]
                        ],                            
                    ]                    
                ]
            ]) @endheading
        @endcell

        @cell
            @if (!$section)
                {{-- Tab "sobre" ativa --}}
                @component('group::pages.groups.sections.about', [
                    'group' => $group
                ]) @endcomponent
            @endif
        @endcell    
    @endgridWithInner
@endsection
