@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.products').' / '.$product->id 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingProduct([
                'product' => $product,
                'tabActive' => 'about',
            ]) @endheadingProduct
        @endcell

        {{-- Geral --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.title'),
                        'value' => $product->title,
                    ],
                    [
                        'label' => __('resources.projects'),
                        'value' => $product->projects()->count(),
                    ],
                    [
                        'label' => __('attrs.created_by'),
                        'value' => $product->user->name,
                        'link' => $product->user->isMember() ?
                            url("members/{$product->user_id}") : null,
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Atividade --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.created_at'),
                        'value' => $product->created_at
                            ->diffForHumans()
                    ],
                    [
                        'label' => __('attrs.updated_at'),
                        'value' => $product->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Descrição --}}
        @cell
            @cardDescription
                {{ $product->description }}            
            @endcardDescription
        @endcell
    @endgridWithInner

    {{-- Editar --}}
    @can('update', $product)
        @fabFixed([
            'fab' => [
                'isLink' => true,
                'icon' => __('icons.edit'),
                'attrs' => [
                    'href' => url("products/{$product->id}/edit"),
                    'title' => __('messages.products.forms.edit_title'),
                ],
            ]
        ]) @endfabFixed
    @endcan
@endsection
