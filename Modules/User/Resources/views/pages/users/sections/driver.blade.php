@layoutGridInner
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.driver'),
            'subtitle' => __('messages.drivers.about'),
            'modifiers' => ['mdc-card--outlined'],
        ])
            @listTwoLine([
                'modifiers' => ['mdc-list--non-interactive'],
                'items' => [
                    [
                        'icon' => material_icon('plate'),
                        'text' => __('columns.plate'),
                        'secondaryText' => $userToShow->driver->plate ?? __('messages.attrs.empty')
                    ],
                    [
                        'icon' => material_icon('points'),
                        'text' => __('columns.points'),
                        'secondaryText' => $userToShow->driver->points ?? __('messages.attrs.empty')
                    ],                        
                ]
            ]) @endlistTwoLine
        @endcard

        @if ($user->can('update', $userToShow))
            @fab([
                'icon' => 'edit',
                'label' => __('messages.drivers.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}/driver"),
                    'title' => __('messages.drivers.edit'),
                    'alt' => __('messages.drivers.edit'),
                ],
            ]) @endfab
        @endif
    @endcell    

@endlayoutGridInner