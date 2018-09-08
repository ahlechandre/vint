@extends('layouts.master', [
    'title' => __('resources.groups').' / '.$group->name.' / '.__('actions.edit') 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingGroupEdit([
                'group' => $group,
                'tabActive' => 'permissions',
            ]) @endheadingGroupEdit
        @endcell

        {{-- Formulário --}}
        @cell
            @list([
                'twoLine' => true,
                'nonInteractive' => true,
                'items' => $groupRoles->map(function ($groupRole) use ($group, $permissionsByResource) {
                    return [
                        'text' => [
                            'primary' => $groupRole->role->name,
                            'secondary' => $groupRole->role->description,
                        ],
                        'meta' => [
                            'dialogContainer' => [
                                'iconButton' => [
                                    'icon' => 'edit',
                                ],
                                'form' => [
                                    'action' => url("groups/{$group->id}/group-roles/{$groupRole->id}"),
                                    'method' => 'put'
                                ],
                                'dialog' => [
                                    'scrollable' => true,
                                    'title' => __("messages.groups.permissions.{$groupRole->role->slug}.title"),
                                    'attrs' => [
                                        'id' => "dialog-groups-roles-{$groupRole->id}"
                                    ],
                                    'component' => [
                                        'view' => 'group::inputs.group-role-permissions',
                                        'props' => [
                                            'groupRole' => $groupRole,
                                            'permissionsByResource' => $permissionsByResource,
                                        ],
                                    ],
                                    'footer' => [
                                        'buttonAccept' => [
                                            'text' => __('actions.update'),
                                            'attrs' => [
                                                'type' => 'submit'
                                            ]
                                        ],
                                        'buttonCancel' => [
                                            'text' => __('actions.cancel'),
                                            'attrs' => [
                                                'type' => 'button'
                                            ]
                                        ]      
                                    ]
                                ]
                            ]
                        ]
                    ];
                }),
            ]) @endlist
        @endcell

    @endgridWithInner
@endsection
