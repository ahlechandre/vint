@extends('layouts.auth', [
    'title' => __('resources.members').' / '.__('headlines.register') 
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
                'pretitle' => __('resources.members'),
                'title' => __('headlines.register'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url('register'),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-register'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'member::inputs.register',
                    'props' => [
                        'role' => $role,
                        'name' => old('name'),
                        'username' => old('username'),
                        'email' => old('email'),
                        'cpf' => old('member.cpf'),
                        'description' => old('member.description'),
                        'siape' => old('servant.siape'),
                        'isProfessor' => true,
                        'rga' => old('student.rga'),
                        'groupsId' => old('member.groups'),
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
