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
            {{-- Formulário de criação. --}}
            @component('group::forms.group', [
                'title' => __('resources.groups'),
                'subtitle' => __('messages.groups.create'),
                'formAction' => url('groups'),
                'formMethod' => 'post',
                'formCancelUrl' => url('users'),
                'validations' => array_map(function ($error) {
                    return $error[0] ?? null;
                }, $errors->toArray()),
                'values' => [
                    'name' => old('name'),
                    'description' => old('description'),
                    'is_active' => true
                ],
            ]) @endcomponent
        @endcell
    @endlayoutGridWithInner
@endsection
