@extends('layouts.master', [
    'breadcrumbs' => [
        [
            'text' => __('resources.members'),
            'attrs' => [
                'href' => url('members')
            ]
        ],
        [
            'text' => $member->user->name,
            'attrs' => [
                'href' => url("members/{$member->user_id}")
            ],
        ],
        [
            'text' => __('actions.edit'),
            'attrs' => [
                'href' => url("members/{$member->user_id}/edit")
            ]
        ]
    ],
])
@section('title', __('resources.members') . " / {$member->user->name} / " . __('actions.edit'))

@section('main')
    @layoutGridWithInner([
        'modifiers' => ['layout-grid--dense']
    ])
        {{-- Formulário --}}
        @cell([
            'when' => ['default' => 12] 
        ])
            @cardWithForm([
                'title' => $member->user->name,
                'subtitle' => __('messages.members.edit'),
            ])
                @form([
                    'action' => url("members/{$member->user_id}"),
                    'method' => 'put',
                    'attrs' => [
                        'id' => 'form-member'
                    ],
                    'withCancel' => true,
                    'withSubmit' => true,             
                    'inputs' => [
                        'view' => 'group::inputs.member',
                        'props' => [
                            'roles' => $roles,
                            'member' => $member
                        ],
                    ]
                ]) @endform
            @endcard
        @endcell
    @endlayoutGridWithInner

    @if (!$member->isStudent())
        {{-- Ao trocar o papel para aluno --}}
        @form([
            'method' => 'put',
            'action' => url("members/{$member->user_id}/role/" . (
                $roles->where('slug', 'student')
                    ->first()
                    ->id
            )),
        ])
            {{-- Inputs específicos --}}
            @component('group::dialogs.members.role-student', [
                'activation' => 'dialog-activation-member-role-student',
                'rga' => $member->student->rga ?? null
            ]) @endcomponent
        @endform
    @endif

    @if (!$member->isServant())
        {{-- Ao trocar o papel para servidor --}}
        @form([
            'method' => 'put',
            'action' => url("members/{$member->user_id}/role/" . (
                $roles->where('slug', 'servant')
                    ->first()
                    ->id                
            )),
        ])
            {{-- Inputs específicos --}}
            @component('group::dialogs.members.role-servant', [
                'activation' => 'dialog-activation-member-role-servant',
                'siape' => $member->servant->siape ?? null,
                'isProfessor' => $member->servant->is_professor ?? false,
            ]) @endcomponent
        @endform
    @endif

    @if (!$member->isCollaborator())
        {{-- Ao trocar o papel para colaborador --}}
        @form([
            'method' => 'put',
            'action' => url("members/{$member->user_id}/role/" . (
                $roles->where('slug', 'collaborator')
                    ->first()
                    ->id                
            )),
        ])
            @component('group::dialogs.members.role-collaborator', [
                'activation' => 'dialog-activation-member-role-collaborator'
            ]) @endcomponent
        @endform
    @endif    
@endsection
