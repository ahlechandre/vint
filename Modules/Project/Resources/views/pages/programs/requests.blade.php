@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.program-requests'),
            'attrs' => [
                'href' => url('program-requests')
            ],
        ]
    ]
])
@section('title', __('resources.program-requests'))

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
                'title' => __('resources.program_requests'),
                'intro' => __('messages.program_requests.index'),
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
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Program::class),
                    'id' => 'dialog-activation-approve-program-requests',
                    'type' => 'button'
                ],
            ]) @endbutton

            {{-- Remover todos --}}
            @button([
                'text' => __('actions.deny_all'),
                'icon' => __('material_icons.deny_all'),
                'attrs' => [
                    'disabled' => $user->cant('updateRequests', \Modules\Project\Entities\Program::class),
                    'id' => 'dialog-activation-deny-program-requests',
                    'type' => 'button'
                ],
            ]) @endbutton
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @layoutGridInner
                @foreach ($programs as $program)
                    @cell([
                        'when' => ['d' => 6, 't' => 4, 'p' => 4]
                    ])
                        {{-- Member request card --}}
                        @cardProgramRequest([
                            'program' => $program
                        ]) @endcardProgramRequest     
                    @endcell
                @endforeach
            @endlayoutGridInner
        @endcell
    @endlayoutGridWithInner

    @can('updateRequests', \Modules\Project\Entities\Program::class)
        {{-- Ao tentar aprovar todos --}}
        @form([
            'method' => 'put',
            'action' => url("program-requests"),
        ])
            {{-- Diálogo --}}
            @dialog([
                'activation' => 'dialog-activation-approve-program-requests',
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
                    'id' => 'dialog-approve-program-requests'
                ],
                'title' => __('messages.program_requests.dialog.approve_all_title')
            ])
                {{ __('messages.program_requests.dialog.approve_all_body', [
                    'count' => $programs->count()
                ]) }}
            @enddialog
        @endform

        {{-- Ao tentar recusar todos --}}
        @form([
            'method' => 'delete',
            'action' => url('program-requests'),
        ])
            {{-- Diálogo --}}
            @dialog([
                'activation' => 'dialog-activation-deny-program-requests',
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
                    'id' => 'dialog-deny-program-requests'
                ],
                'title' => __('messages.program_requests.dialog.deny_all_title')
            ])
                {{ __('messages.program_requests.dialog.deny_all_body', [
                    'count' => $programs->count()
                ]) }}
            @enddialog
        @endform
        
    @endcan
@endsection
