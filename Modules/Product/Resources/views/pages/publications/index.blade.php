@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.publications'),
            'attrs' => [
                'href' => url('publications')
            ],
        ]
    ]
])
@section('title', __('resources.publications'))

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
                'title' => __('resources.publications'),
                'intro' => __('messages.publications.index'),
            ]) @endarticle
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
            'collection' => $publications,
            'items' => $publications->map(function ($publication) use ($user) {
                return [
                    'icon' => __('material_icons.publication'),
                    'meta' => 'arrow_forwar',
                    'text' => $publication->reference,
                    'secondaryText' => $publication->created_at
                        ->diffForHumans(),
                    'attrs' => [
                        'href' => url("/publications/{$publication->id}"),
                    ],
                ];
            }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

    {{-- FAB --}}
    @if ($user->can('create', \Modules\Product\Entities\Publication::class))
        @fab([
            'icon' => 'add',
            'label' => __('messages.publications.new'),
            'modifiers' => ['fab--fixed'],
            'attrs' => [
                'href' => url("/publications/create"),
                'title' => __('messages.publications.new'),
                'alt' => __('messages.publications.new'),
            ],
        ]) @endfab
    @endif
@endsection
