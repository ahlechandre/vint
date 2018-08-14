@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.products'),
            'attrs' => [
                'href' => url('products')
            ],
        ]
    ]
])
@section('title', __('resources.products'))

@section('main')

    {{-- Conteúdo --}}
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        {{-- Títulos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @article([
                'title' => __('resources.products'),
                'intro' => __('messages.products.index'),
            ]) @endarticle
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
            'collection' => $products,
            'items' => $products->map(function ($product) use ($user) {
                return [
                    'icon' => __('material_icons.product'),
                    'meta' => 'arrow_forwar',
                    'text' => $product->title,
                    'secondaryText' => $product->created_at
                        ->diffForHumans(),
                    'attrs' => [
                        'href' => url("/products/{$product->id}"),
                    ],
                ];
            }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

    {{-- FAB --}}
    @if ($user->can('create', \Modules\Product\Entities\Product::class))
        @fab([
            'icon' => 'add',
            'label' => __('messages.products.new'),
            'modifiers' => ['fab--fixed'],
            'attrs' => [
                'href' => url("/products/create"),
                'title' => __('messages.products.new'),
                'alt' => __('messages.products.new'),
            ],
        ]) @endfab
    @endif
@endsection
