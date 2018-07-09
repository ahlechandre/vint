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
            {{-- Formulário de criação. --}}
            @component('user::forms.user-password', [
                'title' => "{$userToEdit->name} / " . __('headlines.password'),
                'subtitle' => __('messages.auth.edit'),
                'formAction' => url("/users/{$userToEdit->id}/password"),
                'formMethod' => 'put',
                'formCancelUrl' => url("/users/{$userToEdit->id}/password"),
                'validations' => [
                    'password' => $errors->get('password')[0] ?? null,
                    'password_confirmation' => $errors->get('password_confirmation')[0] ?? null,
                ],
            ]) @endcomponent
        @endcell
    @endlayoutGridWithInner
@endsection
