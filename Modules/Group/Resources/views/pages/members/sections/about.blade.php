@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.member'),
            'subtitle' => __('messages.members.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'items' => [
                    [
                        'icon' => __('material_icons.name'),
                        'text' => __('attrs.name'),
                        'secondaryText' => $member->user->name
                    ],
                    [
                        'icon' => __("material_icons.{$member->role->slug}"),
                        'text' => __('attrs.role'),
                        'secondaryText' => $member->role->name
                    ],
                    [
                        'icon' => __('material_icons.description'),
                        'text' => __('attrs.description'),
                        'secondaryText' => $member->description
                    ],
                    [
                        'icon' => __('material_icons.cpf'),
                        'text' => __('attrs.cpf'),
                        'secondaryText' => $member->cpf,
                    ],
                    [
                        'icon' => __('material_icons.is_active'),
                        'text' => __('attrs.is_active'),
                        'secondaryText' => __("messages.is_active.{$member->user->is_active}")
                    ],
                ]
            ]) @endlistTwoLine
        @endcard

        @can('update', $member)
            @fab([
                'icon' => 'edit',
                'label' => __('messages.members.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("members/{$member->user_id}/edit"),
                    'title' => __('messages.members.edit'),
                    'alt' => __('messages.members.edit'),
                ],
            ]) @endfab
        @endcan
    @endcell

@endlayoutGridInner