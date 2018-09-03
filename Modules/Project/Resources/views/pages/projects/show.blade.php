@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.projects').' / '.$project->name 
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
                'tabActive' => 'about',
            ]) @endheadingProject
        @endcell

        @cell
            {{-- Informações --}}
            @foreach($project->getAttributes() as $attr => $value)
                <p>
                    {{ $attr }} => {{ $value }}
                </p>
            @endforeach

            {{-- Editar --}}
            @can('update', $project)
                @fabFixed([
                    'fab' => [
                        'isLink' => true,
                        'icon' => __('icons.edit'),
                        'classes' => ['mdc-fab--extended'],
                        'label' => __('actions.edit'),
                        'attrs' => [
                            'href' => url("projects/{$project->id}/edit"),
                            'title' => __('messages.projects.forms.edit_title'),
                        ],
                    ]
                ]) @endfabFixed
            @endcan
        @endcell
    @endgridWithInner
@endsection
