@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.publications'),
            'attrs' => [
                'href' => url('publications')
            ]
        ],
        [
            'text' => $publication->id,
            'attrs' => [
                'href' => url("/publications/{$publication->id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("/publications/{$publication->id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.publications') . " / {$publication->id} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $publication->id,
                'subtitle' => __('messages.publications.edit'),
            ])
                @form([
                    'action' => url("publications/{$publication->id}"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-publication'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        'view' => 'product::inputs.publication',
                        'props' => [
                            'reference' => $publication->reference,
                            'url' => $publication->url,
                            'projectsId' => $publication->projects()
                                ->pluck('id')
                                ->toArray(),
                            'membersUserId' => $publication->members()
                                ->pluck('user_id')
                                ->toArray(),           
                            'projects' => $projects,
                            'members' => $members,
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell

        @can('delete', $publication)
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @button([
                    'text' => __('actions.delete'),
                    'icon' => 'delete_outline',
                    'attrs' => [
                        'type' => 'button',
                        'id' => 'dialog-activation-publication-destroy'
                    ]
                ]) @endbutton
            @endcell

            {{-- Ao tentar remover --}}
            @form([
                'method' => 'delete',
                'action' => url("publications/{$publication->id}"),
            ])
                {{-- Diálogo --}}
                @dialog([
                    'activation' => 'dialog-activation-publication-destroy',
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
                        'id' => 'dialog-publication-destroy'
                    ],
                    'title' => __('messages.publications.dialog.destroy_title')
                ])
                    {{ __('messages.publications.dialog.destroy_body') }}
                @enddialog
            @endform
        @endcan
    @endlayoutGridWithInner
@endsection
