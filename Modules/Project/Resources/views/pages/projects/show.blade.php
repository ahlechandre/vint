@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.projects'),
        $project->name,
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
                'tabActive' => 'about',
            ]) @endheadingProject
        @endcell

        {{-- Geral --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('resources.group'),
                        'value' => $project->group->name,
                        'link' => url("groups/{$project->group_id}")
                    ],
                    [
                        'label' => __('resources.coordinator'),
                        'value' => $project->coordinator
                            ->member
                            ->user
                            ->name,
                        'link' => url("members/{$project->coordinator->member_user_id}")
                    ],
                    [
                        'label' => __('attrs.leader'),
                        'value' => $project->leader
                            ->member
                            ->user
                            ->name ?? null,
                        'link' => $project->leader ?
                            url("members/{$project->leader->member_user_id}") : null
                    ],
                    [
                        'label' => __('attrs.supporter'),
                        'value' => $project->supporter
                            ->member
                            ->user
                            ->name ?? null,
                        'link' => $project->supporter ?
                            url("members/{$project->supporter->member_user_id}") : null
                    ],                    
                    [
                        'label' => __('attrs.start_on'),
                        'value' => $project->start_on
                            ->diffForHumans(),
                    ],
                    [
                        'label' => __('attrs.finish_on'),
                        'value' => $project->finish_on ?
                            $project->finish_on
                                ->diffForHumans() : null,
                    ],                    
                ]
            ]) @endcardShow
        @endcell

        {{-- Atividade --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.created_by'),
                        'value' => $project->user->name,
                        'link' => $project->user->isMember() ?
                            url("members/{$project->user_id}") : null,
                    ],
                    [
                        'label' => __('attrs.created_at'),
                        'value' => $project->created_at
                            ->diffForHumans()
                    ],
                    [
                        'label' => __('attrs.updated_at'),
                        'value' => $project->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Descrição --}}
        @cell
            @cardDescription
                {{ $project->description }}            
            @endcardDescription
        @endcell
    @endgridWithInner

    {{-- Editar --}}
    @can('update', $project)
        @fabFixed([
            'fab' => [
                'isLink' => true,
                'icon' => __('icons.edit'),
                'attrs' => [
                    'href' => url("projects/{$project->id}/edit"),
                    'title' => __('messages.projects.forms.edit_title'),
                ],
            ]
        ]) @endfabFixed
    @endcan
@endsection
