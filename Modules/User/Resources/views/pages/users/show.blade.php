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

        {{-- Geral --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.name'),
                        'value' => $userToShow->name
                    ],
                    [
                        'label' => __('attrs.username'),
                        'value' => $userToShow->username
                    ],
                    [
                        'label' => __('attrs.email'),
                        'value' => $userToShow->email
                    ]
                ]
            ]) @endcardShow
        @endcell

        {{-- Atividade --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.is_active'),
                        'value' => __("messages.attrs.is_active.{$userToShow->is_active}")
                    ],
                    [
                        'label' => __('attrs.created_at'),
                        'value' => $userToShow->created_at
                            ->diffForHumans()
                    ],
                    [
                        'label' => __('attrs.updated_at'),
                        'value' => $userToShow->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Tipo de usuário --}}
        @cell
            @cardShow([
                'data' => [
                    [
                        'label' => __('resources.user_type'),
                        'value' => $userToShow->userType->name,
                        'link' => url("users/{$userToShow->id}/edit"),
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Editar --}}
        @can('update', $userToShow)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.edit'),
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