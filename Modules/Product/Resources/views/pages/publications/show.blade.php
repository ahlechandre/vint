@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.publications'),
            'attrs' => [
                'href' => url('publications')
            ]
        ],
        [
            'text' => $publication->name,
            'attrs' => [
                'href' => url("publications/{$publication->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("/publications/{$publication->id}?section=about")
                ],
            ],
            [
                'text' => __('resources.projects'),
                'isActive' => $section === 'projects',
                'attrs' => [
                    'href' => url("/publications/{$publication->id}?section=projects")
                ],
            ],
            [
                'text' => __('resources.members'),
                'isActive' => $section === 'members',
                'attrs' => [
                    'href' => url("/publications/{$publication->id}?section=members")
                ],
            ],            
        ]
    ],
])
@section('title', __('resources.publications') . " / {$publication->id}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                {{-- "Sobre" --}}
                @component('product::pages.publications.sections.about', [
                    'publication' => $publication
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
