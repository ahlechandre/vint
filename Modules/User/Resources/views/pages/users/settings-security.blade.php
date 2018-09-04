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
            @headingSettings([
                'userToEdit' => $userToEdit,
                'active' => 'security'
            ]) @endheadingSettings
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("users/{$userToEdit->id}/password"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-security'
                ],
                'withCancel' => true,
                'withSubmit' => true,
                'inputs' => [
                    'view' => 'user::inputs.user-password'
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
