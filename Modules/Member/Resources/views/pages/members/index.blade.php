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

        {{-- Mostra se o usuário pode aprovar ou recursar membros --}}
        @if ($user->can('approve', \Modules\Group\Entities\Member::class) || $user->can('deny', \Modules\Group\Entities\Member::class))
            
            {{-- Solicitações de membro --}}
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                {{-- Solicitações de membro --}}
                @buttonLink([
                    'text' => __('headlines.requests') . (
                        $memberRequestsCount ? (
                            $memberRequestsCount < 99 ?
                                " ({$memberRequestsCount})" : ' (+99)'
                        ) : ''
                    ),
                    'modifiers' => ['mdc-button--unelevated'],
                    'attrs' => [
                        'href' => url('member-requests')
                    ],
                ]) @endbuttonLink
            @endcell
        
        @endif        
        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
            'collection' => $members,
            'items' => $members->map(function ($member) {
                return [
                    'icon' => __('material_icons.member'),
                    'meta' => [
                        'icon' => 'arrow_forward',
                    ],
                    'text' => $member->user->name,
                    'secondaryText' => $member->created_at
                        ->diffForHumans(),
                    'attrs' => [
                        'href' => url("/members/{$member->user_id}"),
                    ]
                ];
            }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

@endsection
