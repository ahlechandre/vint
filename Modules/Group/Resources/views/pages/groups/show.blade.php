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
                'href' => url("groups/{$group->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=about")
                ],
            ],
            [
                'text' => __('resources.members'),
                'isActive' => $section === 'members',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=members")
                ],
            ]             
        ]
    ],
])
@section('title', __('resources.groups') . " / {$group->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                @component('group::pages.groups.sections.about', [
                    'group' => $group
                ]) @endcomponent
            @elseif ($section === 'members')
                @component('group::pages.groups.sections.members', [
                    'group' => $group
                ]) @endcomponent                
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
