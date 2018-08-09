@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.member-requests'),
            'attrs' => [
                'href' => url('member-requests')
            ],
        ]
    ]
])
@section('title', __('resources.member-requests'))

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
                'title' => __('resources.member-requests'),
                'intro' => __('messages.members.index'),
            ]) @endarticle
        @endcell
        
        {{-- Ações --}}
        @cell([
            'when' => ['default' => 12],
            'modifiers' => ['mdc-layout-grid--align-right']
        ])
            {{-- Aprovar todos --}}
            @button([
                'text' => __('actions.approve_all'),
                'modifiers' => ['mdc-button--unelevated'],
                'icon' => __('material_icons.approve_all'),
                'attrs' => [
                    'disabled' => $user->cant('approve', \Modules\Group\Entities\Member::class),
                    'id' => 'dialog-activation-approve-member-requests',
                    'type' => 'button'
                ],
            ]) @endbutton

            {{-- Remover todos --}}
            @button([
                'text' => __('actions.deny_all'),
                'icon' => __('material_icons.deny_all'),
                'attrs' => [
                    'disabled' => $user->cant('deny', \Modules\Group\Entities\Member::class),
                    'id' => 'dialog-activation-deny-member-requests',
                    'type' => 'button'
                ],
            ]) @endbutton
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @layoutGridInner
                @foreach ($members as $member)
                    @cell([
                        'when' => ['d' => 6, 't' => 4, 'p' => 4]
                    ])
                        {{-- Member request card --}}
                        @cardMemberRequest([
                            'member' => $member
                        ]) @endcardMemberRequest     
                    @endcell
                @endforeach
            @endlayoutGridInner
        @endcell
    @endlayoutGridWithInner

    @can('approve', \Modules\Group\Entities\Member::class)
        {{-- Ao tentar aprovar todos --}}
        @form([
            'method' => 'put',
            'action' => url("member-requests"),
        ])
            {{-- Diálogo --}}
            @dialog([
                'activation' => "dialog-activation-approve-member-requests",
                'cancel' => [
                    'text' => __('actions.cancel'),
                    'attrs' => [
                        'type' => 'button' 
                    ],
                ],
                'accept' => [
                    'text' => __('actions.confirm'),
                    'attrs' => [
                        'type' => 'submit'
                    ],
                ],
                'attrs' => [
                    'id' => "dialog-approve-member-requests"
                ],
                'title' => __('messages.member_requests.dialog.approve_all_title')
            ])
                {{ __('messages.member_requests.dialog.approve_all_body', [
                    'count' => $members->count()
                ]) }}
            @enddialog
        @endform
    
    @endcan

    @can('deny', \Modules\Group\Entities\Member::class)
        {{-- Ao tentar recusar todos --}}
        @form([
            'method' => 'delete',
            'action' => url("member-requests"),
        ])
            {{-- Diálogo --}}
            @dialog([
                'activation' => "dialog-activation-deny-member-requests",
                'cancel' => [
                    'text' => __('actions.cancel'),
                    'attrs' => [
                        'type' => 'button' 
                    ],
                ],
                'accept' => [
                    'text' => __('actions.confirm'),
                    'attrs' => [
                        'type' => 'submit'
                    ],
                ],
                'attrs' => [
                    'id' => "dialog-deny-member-requests"
                ],
                'title' => __('messages.member_requests.dialog.deny_all_title')
            ])
                {{ __('messages.member_requests.dialog.deny_all_body', [
                    'count' => $members->count()
                ]) }}
            @enddialog
        @endform
    @endcan
@endsection
