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
    @endlayoutGridWithInner
@endsection
