@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.groups'),
            'attrs' => [
                'href' => url('groups')
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('/groups/create')
            ]
        ]
    ],
])
@section('title', __('resources.groups') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => __('resources.groups'),
                'subtitle' => __('messages.groups.create'),
            ])
                @form([
                    'action' => url('groups'),
                    'method' => 'post',
                    'attrs' => [
                        'id' => 'form-group'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        '__view' => 'group::inputs.group',
                        'props' => [
                            'name' => old('name'),
                            'description' => old('description'),
                            'isActive' => true,
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
