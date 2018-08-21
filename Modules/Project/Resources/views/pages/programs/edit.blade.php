@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.programs'),
            'attrs' => [
                'href' => url('programs')
            ]
        ],
        [
            'text' => $program->name,
            'attrs' => [
                'href' => url("programs/{$program->id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("programs/{$program->id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.programs') . " / {$program->id} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        {{-- Formulário --}}
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $program->name,
                'subtitle' => __('messages.programs.edit'),
            ])
                @form([
                    'action' => url("programs/{$program->id}"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-program'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,             
                    'inputs' => [
                        'view' => 'project::inputs.program',
                        'props' => [
                            'servants' => $servants,
                            'name' => $program->name,
                            'coordinatorUserId' => $program->coordinator_user_id,
                            'description' => $program->description,
                            'startOn' => $program->start_on
                                ->format('Y-m-d'),
                            'finishOn' => $program->finish_on ?
                                $program->finish_on
                                    ->format('Y-m-d') : null
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell

        @can('delete', $program)
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @button([
                    'text' => __('actions.delete'),
                    'icon' => 'delete_outline',
                    'attrs' => [
                        'type' => 'button',
                        'id' => 'dialog-activation-program-destroy'
                    ]
                ]) @endbutton
            @endcell

            {{-- Ao tentar remover --}}
            @form([
                'method' => 'delete',
                'action' => url("programs/{$program->id}"),
            ])
                {{-- Diálogo --}}
                @dialog([
                    'activation' => 'dialog-activation-program-destroy',
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
                        'id' => 'dialog-program-destroy'
                    ],
                    'title' => __('messages.programs.dialog.destroy_title')
                ])
                    {{ __('messages.programs.dialog.destroy_body') }}
                @enddialog
            @endform
        @endcan
    @endlayoutGridWithInner

@endsection
