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
            {{-- Formulário de criação. --}}
            @component('user::forms.user', [
                'title' => __('resources.users'),
                'subtitle' => __('messages.users.create'),
                'formAction' => url('/users'),
                'formMethod' => 'post',
                'formCancelUrl' => url('/users'),
                'props' => [
                    'roles' => $roles
                ],
                'validations' => array_map(function ($error) {
                    return $error[0] ?? null;
                }, $errors->toArray()),
                'values' => [
                    'name' => old('name'),
                    'email' => old('email'),
                    'username' => old('username'),
                    'password' => old('password'),
                    'is_active' => true,
                    'role_id' => old('role_id')
                ],
            ]) @endcomponent
        @endcell
    @endlayoutGridWithInner
@endsection
