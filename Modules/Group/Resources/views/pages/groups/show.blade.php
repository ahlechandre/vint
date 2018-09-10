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
                'tabActive' => 'about',
            ]) @endheadingGroup
        @endcell
        
        {{-- Contadores --}}
        @cell([
            'when' => ['d' => 4, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('resources.coordinators'),
                        'value' => $group->coordinators()->count(),
                    ],
                    [
                        'label' => __('resources.programs'),
                        'value' => $group->programs()->count(),
                    ],
                    [
                        'label' => __('resources.projects'),
                        'value' => $group->projects()->count(),
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Contadores --}}
        @cell([
            'when' => ['d' => 4, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('resources.students'),
                        'value' => $group->studentMembers()->count(),
                    ],
                    [
                        'label' => __('resources.collaborators'),
                        'value' => $group->collaboratorMembers()->count(),
                    ],
                    [
                        'label' => __('resources.servants'),
                        'value' => $group->servantMembers()->count(),
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Atividade --}}
        @cell([
            'when' => ['d' => 4, 't' => 8]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.is_active'),
                        'value' => __("messages.attrs.is_active.{$group->is_active}")
                    ],
                    [
                        'label' => __('attrs.created_at'),
                        'value' => $group->created_at
                            ->diffForHumans()
                    ],
                    [
                        'label' => __('attrs.updated_at'),
                        'value' => $group->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Descrição --}}
        @cell
            @cardDescription
                {{ $group->description }}            
            @endcardDescription
        @endcell
    @endgridWithInner

    {{-- Editar --}}
    @can('update', $group)
        @fabFixed([
            'fab' => [
                'isLink' => true,
                'icon' => __('icons.edit'),
                'attrs' => [
                    'href' => url("groups/{$group->id}/edit"),
                    'title' => __('messages.groups.forms.edit_title'),
                    'alt' => __('messages.groups.forms.edit_title')
                ],
            ]
        ]) @endfabFixed
    @endcan    
@endsection
