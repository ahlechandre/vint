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
                'pretitle' => __('headlines.settings'),
                'title' => $userToEdit->name,
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
                            'active' => $section === 'member',
                            'label' => __('resources.member'),
                            'ignore' => !$userToEdit->isMember(),
                            'attrs' => [
                                'href' => request()->fullUrlWithQuery([
                                    'section' => 'member'
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
            @elseif ($section === 'member')
                {{-- Tab "membro" ativa --}}
                @component('user::pages.users.sections.edit-member', [
                    'userToEdit' => $userToEdit,
                    'roles' => $roles
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
