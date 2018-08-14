@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.projects'),
            'attrs' => [
                'href' => url('projects')
            ]
        ],
        [
            'text' => $project->name,
            'attrs' => [
                'href' => url("projects/{$project->id}")
            ]
        ],
    ],    
    'topAppBarTabs' => [
        'tabs' => [
            [
                'text' => __('headlines.about'),
                'isActive' => $section === 'about',
                'attrs' => [
                    'href' => url("projects/{$project->id}?section=about")
                ],
            ],
            [
                'text' => __('resources.students'),
                'isActive' => $section === 'students',
                'attrs' => [
                    'href' => url("projects/{$project->id}?section=students")
                ],
            ],
            [
                'text' => __('resources.publications'),
                'isActive' => $section === 'publications',
                'attrs' => [
                    'href' => url("projects/{$project->id}?section=publications")
                ],
            ],
        ]
    ],
])
@section('title', __('resources.projects') . " / {$project->name}")

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12]
        ])
            @if ($section === 'about')
                {{-- "Sobre" --}}
                @component('project::pages.projects.sections.about', [
                    'project' => $project
                ]) @endcomponent
            @elseif ($section === 'students')
                {{-- "Alunos" --}}
                @component('project::pages.projects.sections.students', [
                    'project' => $project,
                    'students' => $students,
                ]) @endcomponent                
            @endif
        @endcell
    @endlayoutGridWithInner
@endsection
