@layoutGridWithInner([
    'modifiers' => ['layout-grid--dense']
])
    @cell([
        'when' => ['default' => 12]
    ])
        @card([
            'title' => __('resources.group_roles'),
            'subtitle' => __('messages.group_roles.index'),
            'modifiers' => ['mdc-card--outlined'],
        ])
            @listTwoLine([
                'items' => $group->groupRoles
                    ->load('role')
                    ->map(function ($groupRole, $index) {
                    return [
                        'icon' => __("material_icons.{$groupRole->role->slug}"), 
                        'text' => $groupRole->role->name, 
                        'secondaryText' => __('messages.group_roles.role', [
                            'role' => $groupRole->role->name
                        ]),
                        'metas' => [
                            [
                                'icon' => __('material_icons.permissions'),
                                'attrs' => [
                                    'href' => '#',
                                    'title' => __('messages.permissions.edit'),
                                    'id' => "dialog-activation-edit-group-role-{$groupRole->id}"
                                ],
                            ] 
                        ]
                    ];
                })
            ]) @endlistTwoLine
        @endcard
    
    @endcell
@endlayoutGridInner

{{-- Group Role Edit Dialogs --}}
@foreach($group->groupRoles as $groupRole)
    @form([
        'action' => url("groups/{$group->id}/group-roles/{$groupRole->id}"),
        'method' => 'put',
        'inputs' => [
            'view' => 'group::inputs.group-role',
            'props' => [
                'title' => __('messages.group_roles.role', [
                    'role' => $groupRole->role->name
                ]),
                'description' => __('messages.group_roles.description'),
                'activation' => "dialog-activation-edit-group-role-{$groupRole->id}",
                'dialogId' => "dialog-edit-group-role-{$groupRole->id}",
                'acceptText' => __('actions.update'),
                'groupRole' => $groupRole,
                'permissionsByResources' => $permissions->groupBy('resource_id')
                    ->map(function ($permissions, $resourceId) {
                        return [
                            'resource' => $permissions->first()->resource,
                            'permissions' => $permissions,
                        ];
                    })
            ]
        ]
    ]) @endform
@endforeach
