@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.programs'),
            'attrs' => [
                'href' => url('programs')
            ]
        ],
        [
            'text' => $program->name,
            'attrs' => [
                'href' => url("programs/{$program->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("programs/{$program->id}?section=about")
                ],
            ],
            [
                'text' => __('resources.projects'),
                'isActive' => $section === 'projects',
                'attrs' => [
                    'href' => url("programs/{$program->id}?section=projects")
                ],
            ],
        ]
    ],
])
@section('title', __('resources.programs') . " / {$program->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                {{-- "Sobre" --}}
                @component('project::pages.programs.sections.about', [
                    'program' => $program
                ]) @endcomponent
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
