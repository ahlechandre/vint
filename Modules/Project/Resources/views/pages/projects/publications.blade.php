@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.projects'),
        $project->name,
        __('resources.publications'),
    ])    
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingProject([
                'project' => $project,
                'tabActive' => 'publications',
            ]) @endheadingProject
        @endcell

        @cell
            @paginable([
                'paginator' => $publications,
                'list' => [
                    'twoLine' => true,
                    'isNavigation' => true,
                    'items' => $publications->map(function ($publication) use ($user) {
                        return [
                            'icon' => __('icons.publication'),
                            'text' => [
                                'primary' => $publication->reference,
                                'secondary' => $publication->created_at
                                    ->diffForHumans(),
                            ],
                            'attrs' => [
                                'href' => url("publications/{$publication->id}")
                            ],
                            'meta' => [
                                'icon' => __('icons.show')
                            ],
                        ];
                    }),
                ]
            ]) @endpaginable
        @endcell
    @endgridWithInner
@endsection
