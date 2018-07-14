@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.group'),
            'subtitle' => __('messages.groups.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'items' => [
                    [
                        'icon' => __('material_icons.name'),
                        'text' => __('attrs.name'),
                        'secondaryText' => $group->name
                    ],
                    [
                        'icon' => __('material_icons.description'),
                        'text' => __('attrs.description'),
                        'secondaryText' => $group->description
                    ],
                    [
                        'icon' => __('material_icons.is_active'),
                        'text' => __('attrs.is_active'),
                        'secondaryText' => __("messages.is_active.{$group->is_active}")
                    ],                    
                ]
            ]) @endlistTwoLine
        @endcard

        @if ($user->can('update', $group))
            @fab([
                'icon' => 'edit',
                'label' => __('messages.groups.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("/groups/{$group->id}/edit"),
                    'title' => __('messages.groups.edit'),
                    'alt' => __('messages.groups.edit'),
                ],
            ]) @endfab        
        @endif
    @endcell

@endlayoutGridInner