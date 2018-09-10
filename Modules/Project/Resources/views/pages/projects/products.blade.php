@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.projects').' / '.$project->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingProject([
                'project' => $project,
                'tabActive' => 'products',
            ]) @endheadingProject
        @endcell

        @cell
            @paginable([
                'paginator' => $products,
                'list' => [
                    'twoLine' => true,
                    'isNavigation' => true,
                    'items' => $products->map(function ($product) use ($user) {
                        return [
                            'icon' => __('icons.product'),
                            'text' => [
                                'primary' => $product->title,
                                'secondary' => $product->created_at
                                    ->diffForHumans(),
                            ],
                            'attrs' => [
                                'href' => url("products/{$product->id}")
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ],
                        ];
                    }),
                ]
            ]) @endpaginable
        @endcell
    @endgridWithInner
@endsection
