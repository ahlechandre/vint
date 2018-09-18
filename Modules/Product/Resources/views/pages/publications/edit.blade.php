@extends('layouts.master', [
    'title' => get_breadcrumb([
        __('resources.products'),
        __('messages.publications.name', [
            'id' => $publication->id
        ]),
        __('actions.edit')        
    ]) 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @heading([
                'pretitle' => __('resources.publications'),
                'title' => __('messages.publications.edit'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("publications/{$publication->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-publication',
                    'data-vint-auto-init' => 'VintFormPublication'
                ],
                'withCancel' => true,
                'withSubmit' => true,
                'inputs' => [
                    'view' => 'product::inputs.publication',
                    'props' => [
                        'reference' => $publication->reference,
                        'url' => $publication->url,
                        'projects' => $publication->projects
                            ->load('group'),
                        'members' => $publication->members
                            ->load('user')                            
                    ],
                ]
            ]) @endform        
        @endcell

        {{-- Remover --}}
        @cell
            @dialogContainer([
                'fabFixed' => [
                    'fab' => [
                        'icon' => __('icons.delete'),
                        'label' => __('actions.delete'),
                        'classes' => ['mdc-fab--extended'],
                        'attrs' => [
                            'type' => 'button',
                        ],     
                    ]
                ],
                'form' => [
                    'action' => url("publications/{$publication->id}"),
                    'method' => 'delete',
                ],
                'dialog' => [
                    'title' => __('dialogs.publications.delete_title'),
                    'attrs' => [
                        'id' => 'dialog-publication-delete'
                    ],
                    'footer' => [
                        'buttonAccept' => [
                            'text' => __('actions.delete'),
                            'attrs' => [
                                'type' => 'submit'
                            ]
                        ],
                        'buttonCancel' => [
                            'text' => __('actions.cancel'),
                            'attrs' => [
                                'type' => 'button'
                            ]
                        ]
                    ]
                ]
            ]) @enddialogContainer
        @endcell 
    @endgridWithInner
@endsection
