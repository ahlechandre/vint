@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.members'),
            'attrs' => [
                'href' => url('members')
            ],
        ]
    ]
])
@section('title', __('resources.members'))

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
                'title' => __('resources.members'),
                'intro' => __('messages.members.index'),
            ]) @endarticle
        @endcell

        {{-- Ações --}}
        @cell([
            'when' => ['default' => 12],
            'modifiers' => ['mdc-layout-grid--align-right']
        ])
            {{-- Solicitações de membro --}}
            @buttonLink([
                'text' => __('messages.members.actions.requests') . (
                    $memberRequestsCount ? (
                        $memberRequestsCount < 99 ?
                            " ({$memberRequestsCount})" : ' (+99)'
                    ) : ''
                ),
                'modifiers' => ['mdc-button--raised'],
                'attrs' => [
                    'href' => url('member-requests')
                ],
            ]) @endbuttonLink
        @endcell        
        
        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
            'collection' => $members,
            'items' => $members->map(function ($member) {
                return [
                    'icon' => __('material-icons.user'),
                    'meta' => [
                        'icon' => 'arrow_forward',
                    ],
                    'text' => $member->user->name,
                    'secondaryText' => $member->created_at
                        ->diffForHumans(),
                    'attrs' => [
                        'href' => url("/groups/{$member->id}"),
                    ]
                ];
            }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

@endsection
