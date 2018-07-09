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
            'text' => __('resources.affiliates'),
            'attrs' => [
                'href' => url("/users/{$userToEdit->id}/affiliates")
            ]
        ]
    ],
])
@section('title', __('resources.users') . " / {$userToEdit->name} / " . __('resources.affiliates'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12] 
        ])
            {{-- Formulário de criação. --}}
            @component('user::forms.user-affiliates', [
                'title' => "{$userToEdit->name} / " . __('resources.affiliates'),
                'subtitle' => __('messages.user_affiliates.edit'),
                'formAction' => url("/users/{$userToEdit->id}/affiliates"),
                'formMethod' => 'put',
                'formCancelUrl' => url("/users/{$userToEdit->id}?section=affiliates"),
                'values' => [
                    'affiliates' => $userToEdit->affiliates->map(function ($affiliate) {
                        return [
                            'key' => $affiliate->id,
                            'text' => "{$affiliate->name} / {$affiliate->identification_number}",
                        ];
                    })->toArray()
                ]
            ]) @endcomponent
        @endcell
    @endlayoutGridWithInner
@endsection
