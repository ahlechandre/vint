@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.publication'),
            'subtitle' => __('messages.publications.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'items' => [
                    [
                        'icon' => __('material_icons.reference'),
                        'text' => __('attrs.reference'),
                        'secondaryText' => $publication->reference
                    ],
                    [
                        'icon' => __('material_icons.url'),
                        'text' => __('attrs.url'),
                        'secondaryText' => $publication->url ?? 'Não possui'
                    ],                    
                ]
            ]) @endlistTwoLine
        @endcard

        @if ($user->can('update', $publication))
            @fab([
                'icon' => 'edit',
                'label' => __('messages.publications.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("/publications/{$publication->id}/edit"),
                    'title' => __('messages.publications.edit'),
                    'alt' => __('messages.publications.edit'),
                ],
            ]) @endfab        
        @endif
    @endcell

@endlayoutGridInner