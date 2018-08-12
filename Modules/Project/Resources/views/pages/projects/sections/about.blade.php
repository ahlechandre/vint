@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.project'),
            'subtitle' => __('messages.projects.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'items' => [
                    [
                        'icon' => __('material_icons.name'),
                        'text' => __('attrs.name'),
                        'secondaryText' => $project->name
                    ],
                    [
                        'icon' => __('material_icons.description'),
                        'text' => __('attrs.description'),
                        'secondaryText' => $project->description
                    ],
                    [
                        'icon' => __('material_icons.start_on'),
                        'text' => __('attrs.start_on'),
                        'secondaryText' => $project->start_on
                            ->diffForHumans(),
                    ],
                    [
                        'icon' => __('material_icons.finish_on'),
                        'text' => __('attrs.finish_on'),
                        'secondaryText' => $project->finish_on ?
                            $project->finish_on
                                ->diffForHumans() : 'Não indicado',
                    ],
                    [
                        'icon' => __('material_icons.coordinator'),
                        'text' => __('attrs.coordinator'),
                        'secondaryText' => $project->coordinator
                            ->member
                            ->user
                            ->name,
                    ],
                    [
                        'icon' => __('material_icons.leader'),
                        'text' => __('attrs.leader'),
                        'secondaryText' => $project->leader
                            ->member
                            ->user
                            ->name ?? 'Não possui',
                    ],
                    [
                        'icon' => __('material_icons.supporter'),
                        'text' => __('attrs.supporter'),
                        'secondaryText' => $project->supporter
                            ->member
                            ->user
                            ->name ?? 'Não possui',
                    ],            
                ]
            ]) @endlistTwoLine
        @endcard

        @can('update', $project)
            @fab([
                'icon' => 'edit',
                'label' => __('messages.projects.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("projects/{$project->id}/edit"),
                    'title' => __('messages.projects.edit'),
                    'alt' => __('messages.projects.edit'),
                ],
            ]) @endfab
        @endcan
    @endcell

@endlayoutGridInner