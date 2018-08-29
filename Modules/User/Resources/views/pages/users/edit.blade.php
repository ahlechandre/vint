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
                'pretitle' => __('resources.users'),
                'title' => __('messages.users.forms.edit_title'),
                'tabBar' => [
                    'tabs' => [
                        [
                            'active' => $section === 'general',
                            'label' => __('headlines.general'),
                            'attrs' => [
                                'href' => request()->fullUrlWithQuery([
                                    'section' => 'general'
                                ])
                            ]
                        ],
                        [
                            'active' => $section === 'security',
                            'label' => __('headlines.security'),
                            'attrs' => [
                                'href' => request()->fullUrlWithQuery([
                                    'section' => 'security'
                                ])
                            ]
                        ],
                    ]                    
                ]
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @if ($section === 'general')
                {{-- Tab "geral" ativa --}}
                @component('user::pages.users.sections.edit-general', [
                    'userToEdit' => $userToEdit,
                    'userTypes' => $userTypes
                ]) @endcomponent
            @elseif ($section === 'security')
                {{-- Tab "segurança" ativa --}}
                @component('user::pages.users.sections.edit-security', [
                    'userToEdit' => $userToEdit,
                ]) @endcomponent         
            @endif
        @endcell    
    @endgridWithInner
@endsection
