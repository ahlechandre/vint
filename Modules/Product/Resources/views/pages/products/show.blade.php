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
                'href' => url("products/{$product->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("/products/{$product->id}?section=about")
                ],
            ],
            [
                'text' => __('resources.projects'),
                'isActive' => $section === 'projects',
                'attrs' => [
                    'href' => url("/products/{$product->id}?section=projects")
                ],
            ],
        ]
    ],
])
@section('title', __('resources.products') . " / {$product->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                {{-- "Sobre" --}}
                @component('product::pages.products.sections.about', [
                    'product' => $product
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
