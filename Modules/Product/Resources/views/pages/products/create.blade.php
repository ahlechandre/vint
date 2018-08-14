@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.products'),
            'attrs' => [
                'href' => url('products')
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('/products/create')
            ]
        ]
    ],
])
@section('title', __('resources.products') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => __('resources.products'),
                'subtitle' => __('messages.products.create'),
            ])
                @form([
                    'action' => url('products'),
                    'method' => 'post',
                    'attrs' => [
                        'id' => 'form-product'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,  
                    'inputs' => [
                        'view' => 'product::inputs.product',
                        'props' => [
                            'title' => old('title'),
                            'description' => old('description'),
                            'url' => old('url'),
                            'projectsId' => old('projects'),
                            'projects' => $projects,
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
