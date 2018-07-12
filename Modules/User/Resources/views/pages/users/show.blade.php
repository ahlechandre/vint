@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.users'),
            'attrs' => [
                'href' => url('/users')
            ]
        ],
        [
            'text' => $userToShow->name,
            'attrs' => [
                'href' => url("/users/{$userToShow->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => array_merge([
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}?section=about")
                ],
            ],
        ], $user->can('update', $userToShow) ? [
            [
                'text' => __('headlines.security'),
                'isActive' => $section === 'security',
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}?section=security")
                ],
            ]            
        ] : [])
    ],
])
@section('title', __('resources.users') . " / {$userToShow->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                @component('user::pages.users.sections.about', [
                    'userToShow' => $userToShow
                ]) @endcomponent
            @elseif ($section === 'security')
                @component('user::pages.users.sections.security', [
                    'userToShow' => $userToShow
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
