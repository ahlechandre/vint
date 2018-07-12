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
                'items' => [
                    [
                        'icon' => material_icon('name'),
                        'text' => __('attrs.name'),
                        'secondaryText' => $userToShow->name
                    ],
                    [
                        'icon' => material_icon('role'),
                        'text' => __('attrs.role'),
                        'secondaryText' => $userToShow->role->name
                    ],
                    [
                        'icon' => material_icon('username'),
                        'text' => __('attrs.username'),
                        'secondaryText' => $userToShow->username
                    ],
                    [
                        'icon' => material_icon('email'),
                        'text' => __('attrs.email'),
                        'secondaryText' => $userToShow->email
                    ],
                    [
                        'icon' => material_icon('is_active'),
                        'text' => __('attrs.is_active'),
                        'secondaryText' => __("messages.is_active.{$userToShow->is_active}")
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