@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.publications'),
        __('messages.publications.name', [
            'id' => $publication->id
        ]),
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
            @headingPublication([
                'publication' => $publication,
                'tabActive' => 'about',
            ]) @endheadingPublication
        @endcell

        {{-- Geral --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.reference'),
                        'value' => $publication->reference,
                    ],
                    [
                        'label' => __('resources.projects'),
                        'value' => $publication->projects()->count(),
                    ],
                    [
                        'label' => __('resources.members'),
                        'value' => $publication->members()->count(),
                    ],                    
                    [
                        'label' => __('attrs.created_by'),
                        'value' => $publication->user->name,
                        'link' => $publication->user->isMember() ?
                            url("members/{$publication->user_id}") : null,
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
                        'label' => __('attrs.created_at'),
                        'value' => $publication->created_at
                            ->diffForHumans()
                    ],
                    [
                        'label' => __('attrs.updated_at'),
                        'value' => $publication->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell
    @endgridWithInner

    {{-- Editar --}}
    @can('update', $publication)
        @fabFixed([
            'fab' => [
                'isLink' => true,
                'icon' => __('icons.edit'),
                'attrs' => [
                    'href' => url("publications/{$publication->id}/edit"),
                    'title' => __('messages.publications.forms.edit_title'),
                ],
            ]
        ]) @endfabFixed
    @endcan
@endsection
