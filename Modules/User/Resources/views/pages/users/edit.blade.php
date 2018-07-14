@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.users'),
            'attrs' => [
                'href' => url('/users')
            ]
        ],
        [
            'text' => $userToEdit->name,
            'attrs' => [
                'href' => url("/users/{$userToEdit->id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("/users/{$userToEdit->id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.users') . " / {$userToEdit->name} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $userToEdit->name,
                'subtitle' => __('messages.users.edit'),
            ])
                @form([
                    'action' => url("users/{$userToEdit->id}"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-user'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        '__view' => 'user::inputs.user',
                        'props' => [
                            'name' => $userToEdit->name,
                            'roleId' => $userToEdit->role_id,
                            'username' => $userToEdit->username,
                            'email' => $userToEdit->email,
                            'isActive' => $userToEdit->is_active,
                            'roles' => $roles
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
@endsection
