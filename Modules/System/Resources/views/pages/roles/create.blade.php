@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.roles'),
            'attrs' => [
                'href' => url('/roles'),
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('/roles/create'),
            ],
        ]
    ]
])
@section('title', __('resources.roles') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @component('system::forms.role', [
                'title' => ucfirst(__('resources.role')),
                'subtitle' => __('messages.roles.create'),
                'formAction' => url('/roles'),
                'formMethod' => 'post',
                'formCancelUrl' => url('/roles'),
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
                    'name' => old('name'),
                    'description' => old('description'),
                    'is_active' => true,
                    'abilities' => old('abilities'),
                ],
            ]) @endcomponent        
        @endcell
    @endlayoutGridWithInner
@endsection