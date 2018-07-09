@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.roles'),
            'attrs' => [
                'href' => url('/roles')
            ]
        ],
        [
            'text' => $role->name,
            'attrs' => [
                'href' => url('/roles')
            ]
        ],
    ],
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("/roles/{$role->id}?section=about"), 
                ],
            ],
            [
                'text' => ucfirst(__('resources.abilities')),
                'isActive' => $section === 'abilities',
                'attrs' => [
                    'href' => url("/roles/{$role->id}?section=abilities"), 
                ],
            ],            
            [
                'text' => ucfirst(__('resources.users')),
                'isActive' => $section === 'users',
                'attrs' => [
                    'href' => url("/roles/{$role->id}?section=users"), 
                ],
            ],
        ]
    ]
])
@section('title', __('resources.roles') . " / {$role->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])  
        @if ($section === 'about')
            {{-- Sobre --}}
            @cell([
                'when' => ['default' => 12]
            ])
                @component('system::pages.roles.sections.about', [
                    'role' => $role,
                ]) @endcomponent       
            @endcell
        @elseif ($section === 'abilities')
            {{-- Habilidades --}}
            @cell([
                'when' => ['default' => 12]
            ])
                @component('system::pages.roles.sections.abilities', [
                    'role' => $role,
                    'abilities' => $abilities,
                ]) @endcomponent
            @endcell

        @elseif ($section === 'users')
            {{-- Usuários --}}
            @cell([
                'when' => ['default' => 12]
            ])
                @component('system::pages.roles.sections.users', [
                    'users' => $role->users()->simplePaginate(10)
                ]) @endcomponent
            @endcell
        @endif

    @endlayoutGridWithInner
@endsection
