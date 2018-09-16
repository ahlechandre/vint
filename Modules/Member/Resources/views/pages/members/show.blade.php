@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.members'),
        $member->user->name        
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
            @headingMember([
                'member' => $member,
                'tabActive' => 'about',
            ]) @endheadingMember
        @endcell

        {{-- Papel --}}
        @cell
            @cardShow([
                'data' => [
                    [
                        'label' => __('resources.role'),
                        'value' => $member->role->name,
                        'link' => url("members?role={$member->role->slug}"),
                    ],
                ]
            ]) @endcardShow
        @endcell

        {{-- Geral --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => array_merge([
                    [
                        'label' => __('attrs.username'),
                        'value' => $member->user->username
                    ],
                    [
                        'ignore' => !auth()->check() || (
                            $user->id !== $member->user_id &&
                            $user->isMember()            
                        ),
                        'label' => __('attrs.cpf'),
                        'value' => $member->cpf
                    ],                    
                ], $member->isServant() ? [
                    [
                        'label' => __('attrs.is_professor'),
                        'value' => __("messages.attrs.is_professor.{$member->servant->is_professor}")
                    ],
                    [
                        'ignore' => !auth()->check(),
                        'label' => __('attrs.siape'),
                        'value' => $member->servant->siape
                    ]
                ] : [], $member->isStudent() ? [
                    [
                        'ignore' => !auth()->check(),
                        'label' => __('attrs.rga'),
                        'value' => $member->student->rga
                    ]
                ] : [])
            ]) @endcardShow
        @endcell

        {{-- Atividade --}}
        @cell([
            'when' => ['d' => 6, 't' => 4]
        ])
            @cardShow([
                'data' => [
                    [
                        'label' => __('attrs.is_active'),
                        'value' => __("messages.attrs.is_active.{$member->user->is_active}")
                    ],
                    [
                        'label' => __('attrs.created_at'),
                        'value' => $member->created_at
                            ->diffForHumans()
                    ],
                    [
                        'ignore' => !auth()->check() || $user->isMember(),
                        'label' => __('attrs.updated_at'),
                        'value' => $member->updated_at
                            ->diffForHumans()
                    ],
                ]
            ]) @endcardShow
        @endcell
        
    @endgridWithInner
@endsection
