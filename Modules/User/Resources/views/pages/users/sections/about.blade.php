@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('headlines.personal'),
            'subtitle' => __('messages.users.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'modifiers' => ['mdc-list--non-interactive'],
                'items' => [
                    [
                        'icon' => material_icon('name'),
                        'text' => __('columns.name'),
                        'secondaryText' => $userToShow->name
                    ],
                    [
                        'icon' => material_icon('role'),
                        'text' => __('columns.role'),
                        'secondaryText' => $userToShow->role->name
                    ],
                    [
                        'icon' => material_icon('identification_number'),
                        'text' => __('columns.user.identification_number'),
                        'secondaryText' => $userToShow->identification_number
                    ],
                    [
                        'icon' => material_icon('email'),
                        'text' => __('columns.email'),
                        'secondaryText' => $userToShow->email ?? __('messages.attrs.empty')
                    ],
                ]
            ]) @endlistTwoLine
        @endcard

        @if ($user->can('update', $userToShow))
            @fab([
                'icon' => 'edit',
                'label' => __('messages.users.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("/users/{$userToShow->id}/edit"),
                    'title' => __('messages.users.edit'),
                    'alt' => __('messages.users.edit'),
                ],
            ]) @endfab        
        @endif
    @endcell

@endlayoutGridInner