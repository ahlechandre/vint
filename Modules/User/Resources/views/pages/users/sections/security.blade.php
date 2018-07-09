@card([
    'title' => __('headlines.auth'),
    'subtitle' => __('messages.auth.index'),
    'modifiers' => ['mdc-card--outlined'],
    'actions' => [
        [
            'type' => 'button-link',
            'props' => [
                'text' => __('actions.edit'),
                'icon' => 'edit',
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}/password"),
                    'title' => __('actions.edit'),
                    'alt' => __('actions.edit')
                ]
            ]
        ]
    ]
])
    @listTwoLine([
        'modifiers' => ['mdc-list--non-interactive'],
        'items' => [
            [
                'icon' => material_icon('password'),
                'text' => __('columns.password'),
                'secondaryText' => '•••••••••••••'
            ],
        ]
    ]) @endlistTwoLine

@endcard
