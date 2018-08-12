@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.program'),
            'subtitle' => __('messages.programs.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'items' => [
                    [
                        'icon' => __('material_icons.name'),
                        'text' => __('attrs.name'),
                        'secondaryText' => $program->name
                    ],
                    [
                        'icon' => __('material_icons.description'),
                        'text' => __('attrs.description'),
                        'secondaryText' => $program->description
                    ],
                    [
                        'icon' => __('material_icons.start_on'),
                        'text' => __('attrs.start_on'),
                        'secondaryText' => $program->start_on
                            ->diffForHumans(),
                    ],
                    [
                        'icon' => __('material_icons.finish_on'),
                        'text' => __('attrs.finish_on'),
                        'secondaryText' => $program->finish_on ?
                            $program->finish_on
                                ->diffForHumans() : 'Não indicado',
                    ],
                    [
                        'icon' => __('material_icons.coordinator'),
                        'text' => __('attrs.coordinator'),
                        'secondaryText' => $program->coordinator
                            ->member
                            ->user
                            ->name,
                    ],                    
                ]
            ]) @endlistTwoLine
        @endcard

        @can('update', $program)
            @fab([
                'icon' => 'edit',
                'label' => __('messages.programs.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("programs/{$program->id}/edit"),
                    'title' => __('messages.programs.edit'),
                    'alt' => __('messages.programs.edit'),
                ],
            ]) @endfab
        @endcan
    @endcell

@endlayoutGridInner