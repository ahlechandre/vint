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
            @headingGroup([
                'group' => $group,
                'tabActive' => 'about',
            ]) @endheadingGroup
        @endcell

        @cell
            {{-- Card --}}
            @cardShowInfo([
                'cells' => [
                    [
                        'left' => [
                            'list' => [
                                'classes' => ['mdc-list--non-interactive'],
                                'twoLine' => true,
                                'items' => [
                                    [
                                        'text' => [
                                            'primary' => __('attrs.description'),
                                            'secondary' => $group->description,
                                        ]
                                    ]
                                ],
                            ]
                        ],
                        'right' => [
                            'list' => [
                                'classes' => [
                                    'mdc-list--non-interactive',
                                    'list--text-right-tablet',
                                ],
                                'twoLine' => true,
                                'items' => [
                                    [
                                        'text' => [
                                            'primary' => __('attrs.created_at'),
                                            'secondary' => $group->created_at
                                                ->diffForHumans(),
                                        ]
                                    ],
                                    [
                                        'text' => [
                                            'primary' => __('attrs.updated_at'),
                                            'secondary' => $group->created_at
                                                ->diffForHumans(),
                                        ]
                                    ],
                                    [
                                        'text' => [
                                            'primary' => __('attrs.is_active'),
                                            'secondary' => __("messages.attrs.is_active.{$group->is_active}"),
                                        ]
                                    ]                                  
                                ],
                            ]                            
                        ],
                    ]
                ]
            ]) @endcardShowInfo

            {{-- Editar --}}
            @can('update', $group)
                @fabFixed([
                    'fab' => [
                        'isLink' => true,
                        'icon' => __('icons.edit'),
                        'classes' => ['mdc-fab--extended'],
                        'label' => __('actions.edit'),
                        'attrs' => [
                            'href' => url("groups/{$group->id}/edit"),
                            'title' => __('messages.groups.forms.edit_title'),
                            'alt' => __('messages.groups.forms.edit_title')
                        ],
                    ]
                ]) @endfabFixed
            @endcan
        @endcell
    @endgridWithInner
@endsection
