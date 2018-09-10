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
                'tabActive' => 'about',
            ]) @endheadingProgram
        @endcell

        {{-- Geral --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('resources.group'),
                        'value' => $program->group->name,
                        'link' => url("groups/{$program->group_id}")
                    ],
                    [
                        'label' => __('resources.coordinator'),
                        'value' => $program->coordinator
                            ->member
                            ->user
                            ->name,
                        'link' => url("members/{$program->coordinator->member_user_id}")
                    ],
                    [
                        'label' => __('attrs.start_on'),
                        'value' => $program->start_on
                            ->diffForHumans(),
                    ],
                    [
                        'label' => __('attrs.finish_on'),
                        'value' => $program->finish_on ?
                            $program->finish_on
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
                        'value' => $program->user->name,
                        'link' => $program->user->isMember() ?
                            url("members/{$program->user_id}") : null,
                    ],
                    [
                        'label' => __('attrs.created_at'),
                        'value' => $program->created_at
                            ->diffForHumans()
                    ],
                    [
                        'label' => __('attrs.updated_at'),
                        'value' => $program->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Descrição --}}
        @cell
            @cardDescription
                {{ $program->description }}            
            @endcardDescription
        @endcell
    @endgridWithInner

    {{-- Editar --}}
    @can('update', $program)
        @fabFixed([
            'fab' => [
                'isLink' => true,
                'icon' => __('icons.edit'),
                'attrs' => [
                    'href' => url("programs/{$program->id}/edit"),
                    'title' => __('messages.programs.forms.edit_title'),
                ],
            ]
        ]) @endfabFixed
    @endcan
@endsection
