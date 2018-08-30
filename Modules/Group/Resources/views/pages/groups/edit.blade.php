@extends('layouts.master', [
    'title' => __('resources.groups').' / '.$group->name.' / '.__('actions.edit') 
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
                'pretitle' => __('resources.groups'),
                'title' => __('messages.groups.forms.edit_title'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("groups/{$group->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-group'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.group',
                    'props' => [
                        'name' => $group->name,
                        'description' => $group->description,
                        'isActive' => $group->is_active ? true : false,
                    ],
                ]
            ]) @endform
        @endcell

        {{-- Desativar --}}
        @cell
            @form([
                'action' => url("groups/{$group->id}/activation"),
                'method' => 'put',
            ])
                @dialogContainer([
                    'button' => [
                        'text' => __("actions.activation.{$group->is_active}"),
                        'attrs' => [
                            'type' => 'button'
                        ]
                    ],
                    'dialog' => [
                        'attrs' => [
                            'id' => 'dialog-group-is-active',
                        ],
                        'title' => __("messages.groups.dialogs.activation_title_{$group->is_active}"),
                        'footer' => [
                            'buttonAccept' => [
                                'text' => __('actions.confirm'),
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
            @endform
        @endcell
    @endgridWithInner
@endsection
