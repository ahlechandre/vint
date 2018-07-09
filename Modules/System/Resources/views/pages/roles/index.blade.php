@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.roles'),
            'attrs' => [
                'href' => url('/roles')
            ],
        ]
    ]
])
@section('title', __('resources.roles'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @article([
                'title' => __('resources.roles'),
                'intro' => __('messages.roles.index'),
            ]) @endarticle
        @endcell

        @cell([
            'when' => ['default' => 12]
        ])
            @paginable([
                'collection' => $roles,
                'items' => $roles->map(function ($role) {
                    return [
                        'icon' => material_icon('roles'),
                        'text' => $role->name,
                        'secondaryText' => $role->name,
                        'attrs' => [
                            'href' => url("/roles/{$role->id}"),
                        ],
                        'meta' => [
                            'icon' => 'arrow_forward',
                            'attrs' => [
                                'title' => 'Ver papel',
                            ],
                        ],
                    ];
                }),
            ]) @endpaginable
        @endcell
    @endlayoutGridWithInner

    @if ($user->can('create', \Modules\System\Entities\Role::class))
        @fab([
            'icon' => 'add',
            'label' => __('messages.roles.new'),
            'modifiers' => ['fab--fixed'],
            'attrs' => [
                'href' => url('/roles/create'),
                'title' => __('messages.roles.new'),
                'alt' => __('messages.roles.new'),
            ],
        ]) @endfab
    @endif
@endsection