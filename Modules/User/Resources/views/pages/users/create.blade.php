@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.users'),
            'attrs' => [
                'href' => url('/users')
            ]
        ],
        [
            'text' => __('actions.create'),
            'attrs' => [
                'href' => url('/users/create')
            ]
        ]
    ],
])
@section('title', __('resources.users') . ' / ' . __('actions.create'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => __('resources.users'),
                'subtitle' => __('messages.users.create'),
            ])
                @form([
                    'action' => url('users'),
                    'method' => 'post',
                    'attrs' => [
                        'id' => 'form-user'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        'view' => 'user::inputs.user',
                        'props' => [
                            'name' => old('name'),
                            'userTypeId' => old('user_type_id'),
                            'username' => old('username'),
                            'email' => old('email'),
                            'isActive' => true,
                            'userTypes' => $userTypes,
                        ],
                    ]
                ]) @endform            
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
