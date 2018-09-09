@extends('layouts.master', [
    'title' => __('resources.publications').' / '.$publication->id.' / '.__('actions.edit') 
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
                'title' => __('messages.publications.forms.edit_title'),
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
                'button' => [
                    'text' => __('actions.delete')
                ],
                'form' => [
                    'action' => url("publications/{$publication->id}"),
                    'method' => 'delete',
                ],
                'dialog' => [
                    'title' => __('messages.publications.dialogs.delete_title'),
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
