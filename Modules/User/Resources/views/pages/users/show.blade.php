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
            [
                'text' => __('resources.phones'),
                'isActive' => $section === 'phones',
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}?section=phones")
                ],
            ]
        ], $userToShow->isDriver() ? [
            [
                'text' => __('resources.driver'),
                'isActive' => $section === 'driver',
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}?section=driver")
                ],
            ]
        ] : [], $userToShow->isAffiliateUser() ? [
            [
                'text' => __('resources.affiliates'),
                'isActive' => $section === 'affiliates',
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}?section=affiliates")
                ],
            ]
        ] : [], $user->can('update', $userToShow) ? [
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
            @elseif ($section === 'affiliates')
                @component('user::pages.users.sections.affiliates', [
                    'userToShow' => $userToShow,
                    'affiliates' => $userToShow->affiliates()
                        ->simplePaginate(10),
                ]) @endcomponent
            @elseif ($section === 'driver')
                @component('user::pages.users.sections.driver', [
                    'userToShow' => $userToShow
                ]) @endcomponent 
            @elseif ($section === 'phones')
                @component('user::pages.users.sections.phones', [
                    'userToShow' => $userToShow,
                    'phoneTypes' => $phoneTypes,
                    'telecommunicationCompanies' => $telecommunicationCompanies
                ]) @endcomponent
            @elseif ($section === 'security')
                @component('user::pages.users.sections.security', [
                    'userToShow' => $userToShow
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
