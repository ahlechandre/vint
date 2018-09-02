@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.programs').' / '.$program->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingProgram([
                'program' => $program,
                'tabActive' => 'projects',
            ]) @endheadingProgram
        @endcell

        @cell
            @paginable([
                'paginator' => $projects,
                'list' => [
                    'twoLine' => true,
                    'isNavigation' => true,
                    'items' => $projects->map(function ($project) use ($user) {
                        return [
                            'icon' => __('icons.project'),
                            'text' => [
                                'primary' => $project->name,
                                'secondary' => $project->created_at
                                    ->diffForHumans(),
                            ],
                            'attrs' => [
                                'href' => url("projects/{$project->id}")
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
