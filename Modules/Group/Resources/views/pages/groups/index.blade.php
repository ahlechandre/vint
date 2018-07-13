@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.groups'),
            'attrs' => [
                'href' => url('groups')
            ],
        ]
    ]
])
@section('title', __('resources.groups'))

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
                'title' => __('resources.groups'),
                'intro' => __('messages.groups.index'),
            ]) @endarticle
        @endcell

        {{-- Lista de recursos --}}
        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
            'collection' => $groups,
            'items' => $groups->map(function ($group) use ($user) {
                return [
                    'icon' => 'person',
                    'meta' => $user->can('view', $group) ? [
                        'icon' => 'arrow_forward',
                    ] : null,
                    'text' => $group->name,
                    'secondaryText' => $group->created_at
                        ->diffForHumans(),
                    'attrs' => $user->can('view', $group) ? [
                        'href' => url("/groups/{$group->id}"),
                    ] : [],
                ];
            }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

    {{-- FAB --}}
    @if ($user->can('create', \Modules\Group\Entities\Group::class))
        @fab([
            'icon' => 'add',
            'label' => __('messages.groups.new'),
            'modifiers' => ['fab--fixed'],
            'attrs' => [
                'href' => url("/groups/create"),
                'title' => __('messages.groups.new'),
                'alt' => __('messages.groups.new'),
            ],
        ]) @endfab
    @endif
@endsection
