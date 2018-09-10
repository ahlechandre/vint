@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.groups').' / '.$group->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingGroup([
                'group' => $group,
                'tabActive' => 'projects',
            ]) @endheadingGroup
        @endcell
        
        {{-- Solicitações --}}
        @can('updateRequests', [\Modules\Project\Entities\Program::class, $group])
            @cell([
                'classes' => ['mdc-layout-grid--align-right']
            ])
                @if ($requestsCount > 0)
                    @button([
                        'isLink' => true,
                        'icon' => __('icons.forward'),
                        'text' => __('headlines.requests') . (
                            $requestsCount > 99 ?
                                ' (+99)' : " ($requestsCount)"
                        ),
                        'attrs' => [
                            'href' => url("groups/{$group->id}/projects/requests")
                        ]
                    ]) @endbutton
                @endif
            @endcell
        @endcan

        {{-- Paginável --}}
        @cell
            @paginable([
                'paginator' => $projects,
                'list' => [
                    'twoLine' => true,
                    'nonInteractive' => true,
                    'items' => $projects->map(function ($project) use ($user, $group) {
                        return [
                            'icon' => __('icons.project'),
                            'text' => [
                                'link' => url("projects/{$project->id}"),
                                'primary' => $project->name,
                                'secondary' => $project->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'iconButton' => [
                                    'isLink' => true,
                                    'icon' => __('icons.show'),
                                    'attrs' => [
                                        'href' => url("projects/{$project->id}")
                                    ]
                                ]
                            ],
                        ];
                    }),                    
                ]
            ]) @endpaginable

            {{-- Novo --}}
            @can('create', [\Modules\Project\Entities\Program::class, $group])
                @fabFixed([
                    'fab' => [
                        'isLink' => true,
                        'icon' => __('icons.add'),
                        'attrs' => [
                            'href' => url("groups/{$group->id}/projects/create"),
                            'title' => __('messages.groups.projects.forms.create_title'),
                        ],
                    ]
                ]) @endfabFixed
            @endcan
        @endcell
    @endgridWithInner
@endsection
