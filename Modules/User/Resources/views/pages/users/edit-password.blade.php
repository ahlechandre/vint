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
            ]
        ],
        [
            'text' => __('headlines.password'),
            'attrs' => [
                'href' => url("/users/{$userToEdit->id}/password")
            ]
        ]
    ],
])
@section('title', __('resources.users') . " / {$userToEdit->name} / " . __('headlines.password'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $userToEdit->name,
                'subtitle' => __('messages.users.edit-password'),
            ])
                @form([
                    'action' => url("users/{$userToEdit->id}/password"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-user-password'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,                
                    'inputs' => [
                        'view' => 'user::inputs.user-password'
                    ]
                ]) @endform
            @endcard        
        @endcell
    @endlayoutGridWithInner
@endsection
