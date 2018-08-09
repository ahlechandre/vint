@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.groups'),
            'attrs' => [
                'href' => url('groups')
            ]
        ],
        [
            'text' => $group->name,
            'attrs' => [
                'href' => url("/groups/{$group->id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("/groups/{$group->id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.groups') . " / {$group->name} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $group->name,
                'subtitle' => __('messages.groups.edit'),
            ])
                @form([
                    'action' => url("groups/{$group->id}"),
                    'method' => 'post',
                    'attrs' => [
                        'id' => 'form-group'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        '__view' => 'group::inputs.group',
                        'props' => [
                            'name' => $group->name,
                            'description' => $group->description,
                            'isActive' => true,
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
