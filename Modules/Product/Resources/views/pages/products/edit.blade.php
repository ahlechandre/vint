@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.products'),
            'attrs' => [
                'href' => url('products')
            ]
        ],
        [
            'text' => $product->name,
            'attrs' => [
                'href' => url("/products/{$product->id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("/products/{$product->id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.products') . " / {$product->name} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $product->name,
                'subtitle' => __('messages.products.edit'),
            ])
                @form([
                    'action' => url("products/{$product->id}"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-product'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        'view' => 'product::inputs.product',
                        'props' => [
                            'title' => $product->title,
                            'description' => $product->description,
                            'url' => $product->url,
                            'projectsId' => $product->projects()
                                ->pluck('id')
                                ->toArray(),
                            'projects' => $projects,
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell

        @can('delete', $product)
            @cell([
                'when' => ['default' => 12],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @button([
                    'text' => __('actions.delete'),
                    'icon' => 'delete_outline',
                    'attrs' => [
                        'type' => 'button',
                        'id' => 'dialog-activation-product-destroy'
                    ]
                ]) @endbutton
            @endcell

            {{-- Ao tentar remover --}}
            @form([
                'method' => 'delete',
                'action' => url("products/{$product->id}"),
            ])
                {{-- Diálogo --}}
                @dialog([
                    'activation' => 'dialog-activation-product-destroy',
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
                        'id' => 'dialog-product-destroy'
                    ],
                    'title' => __('messages.products.dialog.destroy_title')
                ])
                    {{ __('messages.products.dialog.destroy_body') }}
                @enddialog
            @endform
        @endcan
    @endlayoutGridWithInner
@endsection
