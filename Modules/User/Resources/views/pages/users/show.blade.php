{{-- Layout --}}
@extends('layouts.master', [
    'title' => __('resources.users').' / '.$userToShow->name
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
                'pretitle' => __('resources.users'),
                'title' => $userToShow->name,
            ]) @endheading
        @endcell

        {{-- Card --}}
        @cell
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
                                            'primary' => __('attrs.email'),
                                            'secondary' => $userToShow->email,
                                        ]
                                    ],
                                    [
                                        'text' => [
                                            'primary' => __('attrs.username'),
                                            'secondary' => $userToShow->username,
                                        ]
                                    ],
                                    [
                                        'text' => [
                                            'primary' => __('resources.user_type'),
                                            'secondary' => $userToShow->userType->name,
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
                                            'secondary' => $userToShow->created_at
                                                ->diffForHumans(),
                                        ]
                                    ],
                                    [
                                        'text' => [
                                            'primary' => __('attrs.updated_at'),
                                            'secondary' => $userToShow->created_at
                                                ->diffForHumans(),
                                        ]
                                    ],
                                    [
                                        'text' => [
                                            'primary' => __('attrs.is_active'),
                                            'secondary' => __("messages.attrs.is_active.{$userToShow->is_active}"),
                                        ]
                                    ]                                                  
                                ],
                            ]                            
                        ],
                    ]
                ]
            ]) @endcardShowInfo
        @endcell

        {{-- Editar --}}
        @can('update', $userToShow)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.edit'),
                    'classes' => ['mdc-fab--extended'],
                    'label' => __('actions.edit'),
                    'attrs' => [
                        'href' => url("users/{$userToShow->id}/edit"),
                        'title' => __('messages.users.forms.edit_title'),
                        'alt' => __('messages.users.forms.edit_title')
                    ],
                ]
            ]) @endfabFixed
        @endcan
    @endgridWithInner
@endsection