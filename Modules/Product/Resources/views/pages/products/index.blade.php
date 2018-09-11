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
        
        {{-- Paginável --}}
        @cell
            @paginableProducts([
                'products' => $products,
            ]) @endpaginableProducts
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
