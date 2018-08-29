{{-- Layout --}}
@extends('layouts.master', [
    'title' => __('resources.groups')
])

{{-- Conteúdo --}}
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
                'title' => __('resources.groups'),
                'content' => __('messages.groups.subheading'),
                'action' => $groupsRequested->isEmpty() ?
                    [
                        'button' => [
                            'text' => __('headlines.requests'),
                            'classes' => ['mdc-button--outlined'],
                            'attrs' => [
                                'disabled' => ''
                            ]
                        ]
                    ] :
                    [
                        'dialogContainer' => [
                            'button' => [
                                'text' => __('headlines.requests'),
                                'classes' => ['mdc-button--outlined']
                            ],
                            'dialog' => [
                                'attrs' => [
                                    'id' => 'dialog-me-groups-requests',
                                ], 
                                'scrollable' => true,
                                'title' => __('messages.groups.dialogs.me_groups_requests'),
                                'component' => [
                                    'view' => 'group::dialogs.groups.me-requests',
                                    'props' => [
                                        'groups' => $groupsRequested
                                    ],
                                ],
                                'footer' => [
                                    'buttonAccept' => [
                                        'text' => __('actions.ok'),
                                        'attrs' => [
                                            'type' => 'button'
                                        ],
                                    ],
                                ]                        
                            ]                        
                        ]                    
                    ]
            ]) @endheading
        @endcell
        
        @cell
            {{-- Paginável --}}
            @paginable([
                'paginator' => $groups,
                'items' => $groups->map(function ($group) {
                    return [
                        'text' => [
                            'primary' => $group->name,
                            'secondary' => $group->created_at
                                ->diffForHumans(),
                        ],
                        'meta' => [
                            'icon' => __('icons.show'),
                        ],
                        'attrs' => [
                            'href' => url("groups/{$group->id}")
                        ]
                    ];
                }),
            ]) @endpaginable        
        @endcell
        
        {{-- Novo --}}
        @can('create', \Modules\Group\Entities\Group::class)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.add'),
                    'classes' => ['mdc-fab--extended'],
                    'label' => __('actions.new'),
                    'attrs' => [
                        'href' => url('groups/create'),
                        'title' => __('messages.groups.forms.create_title'),
                        'alt' => __('messages.groups.forms.create_title')
                    ],
                ]
            ]) @endfabFixed
        @endcan
    @endgridWithInner
@endsection
