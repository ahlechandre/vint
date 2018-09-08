{{-- Layout --}}
@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.products')
])

{{-- Conteúdo --}}
@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        @cell
            {{-- Heading --}}
            @heading([
                'title' => __('resources.products'),
                'content' => __('messages.products.subheading'),
            ]) @endheading
        @endcell
        
        @cell
            {{-- Paginável --}}
            @paginable([
                'paginator' => $products,
                'list' => [
                    'isNavigation' => true,
                    'twoLine' => true,
                    'items' => $products->map(function ($product) {
                        return [
                            'icon' => __('icons.product'),
                            'text' => [
                                'primary' => $product->title,
                                'secondary' => $product->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'icon' => __('icons.show'),
                            ],
                            'attrs' => [
                                'href' => url("products/{$product->id}")
                            ]
                        ];
                    }),                    
                ]
            ]) @endpaginable
        @endcell
        
        {{-- Novo --}}
        @can('create', \Modules\Product\Entities\Product::class)
            @fabFixed([
                'fab' => [
                    'isLink' => true,
                    'icon' => __('icons.add'),
                    'classes' => ['mdc-fab--extended'],
                    'label' => __('actions.new'),
                    'attrs' => [
                        'href' => url('products/create'),
                        'title' => __('messages.products.forms.create_title'),
                    ],
                ]
            ]) @endfabFixed
        @endcan
    @endgridWithInner
@endsection
