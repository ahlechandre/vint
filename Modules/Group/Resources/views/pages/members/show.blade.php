@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.members'),
            'attrs' => [
                'href' => url('members')
            ]
        ],
        [
            'text' => $member->user->name,
            'attrs' => [
                'href' => url("members/{$member->user_id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("members/{$member->user_id}?section=about")
                ],
            ],
            [
                'text' => __('resources.projects'),
                'isActive' => $section === 'projects',
                'attrs' => [
                    'href' => url("members/{$member->user_id}?section=projects")
                ],
            ],
            [
                'text' => __('resources.publications'),
                'isActive' => $section === 'publications',
                'attrs' => [
                    'href' => url("members/{$member->user_id}?section=publications")
                ],
            ],
        ]
    ],
])
@section('title', __('resources.members') . " / {$member->user->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                {{-- "Sobre" --}}
                @component('group::pages.members.sections.about', [
                    'member' => $member
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
