@extends('layouts.master', [
    'title' => __('resources.products').' / '.$product->title.' / '.__('actions.edit') 
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
                'pretitle' => __('resources.products'),
                'title' => __('messages.products.forms.edit_title'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("products/{$product->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-product',
                    'data-vint-auto-init' => 'VintFormProduct'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'product::inputs.product',
                    'props' => [
                        'title' => $product->title,
                        'description' => $product->description,
                        'url' => $product->url,
                        'projects' => $product->projects
                            ->load('group')
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
                    'action' => url("products/{$product->id}"),
                    'method' => 'delete',
                ],
                'dialog' => [
                    'title' => __('messages.products.dialogs.delete_title'),
                    'attrs' => [
                        'id' => 'dialog-product-delete'
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
