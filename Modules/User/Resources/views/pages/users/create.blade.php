@extends('layouts.master', [
    'title' => __('resources.users').' / '.__('actions.new') 
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
                'pretitle' => __('resources.users'),
                'title' => __('messages.users.forms.create_title'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url('users'),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-user'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'user::inputs.user',
                    'props' => [
                        'name' => old('name'),
                        'userTypeId' => old('user_type_id'),
                        'username' => old('username'),
                        'email' => old('email'),
                        'isActive' => true,
                        'userTypes' => $userTypes,
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
