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
            ],
            [
                'text' => __('resources.programs'),
                'isActive' => $section === 'programs',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=programs")
                ],
            ],
            [
                'text' => __('resources.projects'),
                'isActive' => $section === 'projects',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=projects")
                ],
            ],
            [
                'text' => __('resources.invites'),
                'isActive' => $section === 'invites',
                'attrs' => [
                    'href' => url("/groups/{$group->id}?section=invites")
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
            @elseif ($section === 'invites')
                @component('group::pages.groups.sections.invites', [
                    'group' => $group
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
