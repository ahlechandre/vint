@extends('layouts.default') 
@section('title', 'Novo membro')

@section('main')
    {{-- Surface --}}
    @component('components.ui.top-app-bar-surface', [
      'modifiers' => [
        'top-app-bar-surface--expanded',
        'top-app-bar-surface--min-height',
      ]
    ]) @endcomponent
    
    {{-- Content --}}
    @layoutGridWithInner([
      'modifiers' => ['layout-grid--dense']
    ])
        @cell([
        'when' => ['default' => 12],
        ])
            @cardWithForm([
                'title' => __('resources.member'),
                'subtitle' => __('messages.members.register'),
            ])
                @form([
                    'action' => url('register'),
                    'method' => 'post',
                    'withSubmit' => true,
                    'inputs' => [
                        '__view' => 'group::inputs.register',
                        'props' => [
                            'memberType' => $memberType,
                            'invite' => $invite,
                            'name' => old('name'),
                            'username' => old('username'),
                            'email' => old('email'),
                            'cpf' => old('member.cpf'),
                            'description' => old('member.description'),
                            'siape' => old('servant.siape'),
                            'isProfessor' => true,
                            'rga' => old('student.rga'),
                        ],
                    ],
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner
  
@endsection