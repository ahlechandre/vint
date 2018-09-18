@extends('layouts.master', [
    'title' => get_breadcrumb([
        __('resources.users'), 
        $userToEdit->name,
        __('headlines.settings'), 
        __('resources.member'), 
    ])  
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingSettings([
                'userToEdit' => $userToEdit,
                'active' => 'member'
            ]) @endheadingSettings
        @endcell

        {{-- Papel --}}
        @cell([
            'classes' => ['mdc-layout-grid--align-right']
        ])
            @menuAnchor([
                'button' => [
                    'icon' => 'expand_more',
                    'text' => __('resources.role'),
                ],
                'menu' => [
                    'list' => [
                        'items' => $roles->map(function ($role) use ($userToEdit) {
                            return [
                                'icon' => $userToEdit->member->role_id === $role->id ?
                                    'check' : ' ',
                                'text' => $role->name,
                                'classes' => ['dialog-activation'],
                                'attrs' => [
                                    'data-dialog-activation' => "dialog-activation-member-role-{$role->id}",
                                    'data-vint-auto-init' => 'VintDialogActivation'
                                ]
                            ];
                        })
                    ],
                ]
            ]) @endmenuAnchor
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("members/{$userToEdit->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-member'
                ],
                'withCancel' => true,
                'withSubmit' => true,             
                'inputs' => [
                    'view' => 'member::inputs.member',
                    'props' => [
                        'roles' => $roles,
                        'member' => $userToEdit->member
                    ],
                ]
            ]) @endform
        @endcell
    @endgridWithInner

    {{-- Dialogs --}}
    @foreach($roles as $role)
        @if ($role->id !== $userToEdit->member->role_id)
            @form([
                'action' => url("members/{$userToEdit->id}/roles/{$role->id}"),
                'method' => 'put'
            ])
                @dialog([
                    'title' => __("messages.settings.member.dialog.role_{$role->slug}_title"),
                    'attrs' => [
                        'id' => "dialog-activation-member-role-{$role->id}"
                    ],
                    'component' => [
                        'view' => "member::inputs.member-role-{$role->slug}",
                        'props' => [
                            'member' => $userToEdit->member
                        ]
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
                ]) @enddialog            
            @endform        
        @endif
    @endforeach
@endsection
