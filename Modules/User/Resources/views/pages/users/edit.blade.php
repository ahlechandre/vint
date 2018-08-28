@extends('layouts.master', [
    'title' => __('resources.users').' / '.$userToEdit->name.' / '.__('actions.edit') 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @heading([
                'title' => __('messages.users.forms.edit_title'),
                'content' => __('messages.users.forms.edit_content'),
                'tabBar' => [
                    'tabs' => [
                        [
                            'active' => true,
                            'label' => __('headlines.general'),
                        ],
                        [
                            'label' => __('headlines.security'),
                        ],
                    ]                    
                ]
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("users/{$userToEdit->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-user'
                ],
                'withCancel' => true,
                'withSubmit' => true,
                'inputs' => [
                    'view' => 'user::inputs.user',
                    'props' => [
                        'name' => $userToEdit->name,
                        'userTypeId' => $userToEdit->user_type_id,
                        'username' => $userToEdit->username,
                        'email' => $userToEdit->email,
                        'isActive' => $userToEdit->is_active ? true : false,
                        'userTypes' => $userTypes,
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
