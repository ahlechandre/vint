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
            {{-- Formulário de criação. --}}
            @component('group::forms.group', [
                'title' => $group->name,
                'subtitle' => __('messages.groups.edit'),
                'formAction' => url("/groups/{$group->id}"),
                'formMethod' => 'put',
                'formCancelUrl' => url("/groups/{$group->id}"),
                'validations' => array_map(function ($error) {
                    return $error[0] ?? null;
                }, $errors->toArray()),
                'values' => [
                    'name' => $group->name,
                    'description' => $group->description,
                    'is_active' => $group->is_active ? true : false,
                ],
            ]) @endcomponent
        @endcell
    @endlayoutGridWithInner
@endsection
