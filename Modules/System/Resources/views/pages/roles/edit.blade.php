@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.roles'),
            'attrs' => [
                'href' => url('/roles'),
            ]
        ],
        [
            'text' => $role->name,
            'attrs' => [
                'href' => url("/roles/{$role->id}"),
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("/roles/{$role->id}/edit"),
            ],
        ]
    ]
])
@section('title', __('resources.roles') . " / {$role->name} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @component('system::forms.role', [
                'title' => $role->name,
                'subtitle' => __('messages.roles.edit'),
                'formAction' => url("/roles/{$role->id}"),
                'formMethod' => 'put',
                'formCancelUrl' => url("/roles/{$role->id}"),
                'props' => [
                    'resourcesAbilities' => $abilities->groupBy('resource_id')
                        ->map(function ($abilities, $resourceId) {
                            return [
                                'resource' => $abilities->first()->resource,
                                'abilities' => $abilities,
                            ];
                        }),
                ],
                'values' => [
                    'name' => $role->name,
                    'description' => $role->description,
                    'is_active' => $role->is_active ? true : false,
                    'abilities' => $role->abilities
                        ->pluck('id')
                        ->toArray(),
                ],
            ]) @endcomponent        
        @endcell
    @endlayoutGridWithInner
@endsection