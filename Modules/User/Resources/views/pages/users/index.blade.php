@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => 'Usuários',
            'attrs' => [
                'href' => url('/users')
            ],
        ]
    ]
])
@section('title', 'Usuários')

@section('main')

    {{-- Conteúdo --}}
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        {{-- Títulos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @article([
                'title' => 'Usuários',
                'intro' => 'Lista de usuários mais recentes no sistema.',
            ]) @endarticle
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
            'collection' => $users,
            'items' => $users->map(function ($userToShow) use ($user) {
                return [
                    'icon' => 'person',
                    'meta' => $user->can('view', $userToShow) ? [
                        'icon' => 'arrow_forward',
                    ] : null,
                    'text' => $userToShow->name,
                    'secondaryText' => $userToShow->created_at
                        ->diffForHumans(),
                    'attrs' => $user->can('view', $userToShow) ? [
                        'href' => url("/users/{$userToShow->id}"),
                    ] : [],
                ];
            }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

    {{-- FAB --}}
    @if ($user->can('create', \Modules\User\Entities\User::class))
        @fab([
            'icon' => 'add',
            'label' => __('messages.users.new'),
            'modifiers' => ['fab--fixed'],
            'attrs' => [
                'href' => url("/users/create"),
                'title' => __('messages.users.new'),
                'alt' => __('messages.users.new'),
            ],
        ]) @endfab
    @endif
@endsection
