@layoutGridWithInner([
    'modifiers' => ['layout-grid--dense']
])
    @cell([
        'when' => ['default' => 12]
    ])
        @card([
            'title' => __('resources.students'),
            'subtitle' => __('messages.students.index'),
            'modifiers' => ['mdc-card--outlined'],
        ])
            @listTwoLine([
                'items' => $project->students
                    ->load('member.user')
                    ->map(function ($student) {
                        return [
                            'icon' => __('material_icons.student'), 
                            'text' => $student->member->user->name, 
                            'secondaryText' => $student->pivot->is_scholarship ? 'Bolsista' : 'Não bolsista',
                            'metas' => [
                                [
                                    'icon' => 'edit',
                                    'attrs' => [
                                        'href' => '#',
                                        'title' => __('actions.edit'),
                                        'id' => "dialog-activation-edit-student-{$student->member_user_id}"
                                    ],
                                ],
                                [
                                    'icon' => 'close',
                                    'attrs' => [
                                        'href' => '#',
                                        'title' => __('actions.delete'),
                                        'id' => "dialog-activation-destroy-student-{$student->member_user_id}"
                                    ],
                                ] 
                            ]
                        ];
                    })
            ]) @endlistTwoLine
        @endcard
    
    @endcell
@endlayoutGridInner


{{-- Coordinator Create Dialog --}}
@form([
    'action' => url("projects/{$project->id}/students"),
    'method' => 'post',
    'inputs' => [
        'view' => 'project::dialogs.students.create',
        'props' => [
            'title' => __('messages.students.create'),
            'description' => __('messages.students.description_on_create'),
            'activation' => 'dialog-activation-create-student',
            'dialogId' => 'dialog-create-student',
            'acceptText' => __('actions.confirm'),
            'students' => $students,
        ]
    ]
]) @endform

{{-- Coordinator Edit Dialogs --}}
@foreach($project->students as $student)
    @form([
        'action' => url("projects/{$project->id}/students/{$student->member_user_id}"),
        'method' => 'put',
        'inputs' => [
            'view' => 'project::dialogs.students.update',
            'props' => [
                'title' => __('messages.students.edit'),
                'description' => __('messages.students.description_on_edit'),
                'activation' => "dialog-activation-edit-student-{$student->member_user_id}",
                'dialogId' => "dialog-edit-student-{$student->member_user_id}",
                'acceptText' => __('actions.edit'),
                'student' => $student,
            ]
        ]
    ]) @endform
@endforeach

{{-- Coordinator Destroy Dialogs --}}
@foreach($project->students as $student)
    @form([
        'action' => url("projects/{$project->id}/students/{$student->member_user_id}"),
        'method' => 'delete'
    ])
        @dialog([
            'activation' => "dialog-activation-destroy-student-{$student->member_user_id}",
            'title' => __('messages.student.destroy'),
            'attrs' => [
                'id' => "dialog-destroy-student-{$student->member_user_id}",
            ],
            'cancel' => [
                'text' => __('actions.cancel'),
                'attrs' => [
                    'type' => 'button'
                ],
            ],
            'accept' => [
                'text' => __('actions.delete'),
                'attrs' => [
                    'type' => 'submit'
                ],
            ],        
        ])
            @layoutGridInner
                {{-- Descrição --}}
                @cell([
                    'when' => [
                        'desktop' => 12,
                        'tablet' => 8,
                    ]
                ])
                    <p class="mdc-typography--subtitle1">
                        {{ __('messages.students.description_on_destroy') }}
                    </p>
                @endcell
            @endlayoutGridInner
        @enddialog  
    @endform
@endforeach

@fab([
    'icon' => 'add',
    'label' => __('messages.students.new'),
    'modifiers' => ['fab--fixed'],
    'attrs' => [
        'id' => 'dialog-activation-create-student',
        'title' => __('messages.students.new'),
        'alt' => __('messages.students.new'),
    ],
]) @endfab
