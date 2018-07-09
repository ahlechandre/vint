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
            {{-- Formulário de criação. --}}
            @component('user::forms.user', [
                'title' => $userToEdit->name,
                'subtitle' => __('messages.users.edit'),
                'formAction' => url("/users/{$userToEdit->id}"),
                'formMethod' => 'put',
                'formCancelUrl' => url("/users/{$userToEdit->id}"),
                'props' => [
                    'roles' => $roles
                ],
                'validations' => array_map(function ($error) {
                    return $error[0] ?? null;
                }, $errors->toArray()),
                'values' => [
                    'name' => $userToEdit->name,
                    'identification_number' => $userToEdit->identification_number,
                    'email' => $userToEdit->email,
                    'is_active' => $userToEdit->is_active ? true : false,
                    'role_id' => $userToEdit->role_id
                ],
            ]) @endcomponent
        @endcell
    @endlayoutGridWithInner
@endsection
