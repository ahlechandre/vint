@extends('layouts.master', [
    'title' => get_breadcrumb([
        __('resources.products'),
        $product->title,
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
                'pretitle' => __('resources.products'),
                'title' => __('messages.products.edit'),
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
                    'action' => url("products/{$product->id}"),
                    'method' => 'delete',
                ],
                'dialog' => [
                    'title' => __('dialogs.products.delete_title', [
                        'title' => $product->title
                    ]),
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
