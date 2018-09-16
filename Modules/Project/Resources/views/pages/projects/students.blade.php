@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => get_breadcrumb([
        __('resources.projects'),
        $project->name,
        __('resources.students'),
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
            @headingProject([
                'project' => $project,
                'tabActive' => 'students',
            ]) @endheadingProject
        @endcell
        
        {{-- Paginável --}}
        @cell
            @paginable([
                'paginator' => $students,
                'list' => [
                    'twoLine' => true,
                    'nonInteractive' => true,
                    'items' => $students->map(function ($student) use ($user, $project) {
                        return [
                            'icon' => __('icons.student'),
                            'text' => [
                                'link' => url("members/{$student->member_user_id}"),
                                'primary' => $student->member
                                    ->user
                                    ->name,
                                'secondary' => $student->created_at
                                    ->diffForHumans().", ".__("attrs.is_scholarship_value.{$student->pivot->is_scholarship}"),
                            ],
                            'metas' => [
                                [
                                    'ignore' => !auth()->check() || $user->cant('updateStudents', $project),
                                    'dialogContainer' => [
                                        'iconButton' => [
                                            'icon' => __('icons.edit'),
                                        ],
                                        'form' => [
                                            'action' => url("projects/{$project->id}/students/{$student->member_user_id}"),
                                            'method' => 'put'
                                        ],
                                        'dialog' => [
                                            'title' => __('messages.projects.students.dialogs.update_title'),
                                            'attrs' => [
                                                'id' => "dialog-students-edit-{$student->member_user_id}"
                                            ],
                                            'component' => [
                                                'view' => 'project::inputs.project-student-update',
                                                'props' => [
                                                    'student' => $student
                                                ],
                                            ],
                                            'footer' => [
                                                'buttonAccept' => [
                                                    'text' => __('actions.update'),
                                                    'attrs' => [
                                                        'type' => 'submit'
                                                    ]
                                                ],
                                                'buttonCancel' => [
                                                    'text' => __('actions.cancel'),
                                                    'attrs' => [
                                                        'type' => 'button'
                                                    ]
                                                ]         
                                            ]
                                        ]
                                    ],
                                ],             
                                [
                                    'ignore' => !auth()->check() || $user->cant('deleteStudents', $project),
                                    'dialogContainer' => [
                                        'iconButton' => [
                                            'icon' => __('icons.remove'),
                                        ],
                                        'form' => [
                                            'action' => url("projects/{$project->id}/students/{$student->member_user_id}"),
                                            'method' => 'delete'
                                        ],
                                        'dialog' => [
                                            'title' => __('messages.projects.students.dialogs.delete_title'),
                                            'attrs' => [
                                                'id' => "dialog-students-delete-{$student->member_user_id}"
                                            ],
                                            'footer' => [
                                                'buttonAccept' => [
                                                    'text' => __('actions.confirm'),
                                                    'attrs' => [
                                                        'type' => 'submit'
                                                    ]
                                                ],
                                                'buttonCancel' => [
                                                    'text' => __('actions.cancel'),
                                                    'attrs' => [
                                                        'type' => 'button'
                                                    ]
                                                ]                        
                                            ]
                                        ]
                                    ],
                                ],     
                                [
                                    'iconButton' => [
                                        'isLink' => true, 
                                        'icon' => __('icons.show'),
                                        'attrs' => [
                                            'href' => url("members/{$student->member_user_id}")
                                        ]
                                    ]
                                ]
                            ],
                        ];
                    }),                
                ]
            ]) @endpaginable

            {{-- Novo --}}
            @can('createStudents', $project)
                @fabFixed([
                    'fab' => [
                        'icon' => __('icons.add'),
                        'classes' => ['dialog-activation'],
                        'attrs' => [
                            'title' => __('messages.projects.students.create'),
                            'data-dialog-activation' => 'dialog-project-student-create',
                            'data-vint-auto-init' => 'VintDialogActivation'
                        ],
                    ]
                ]) @endfabFixed

                @form([
                    'action' => url("projects/{$project->id}/students"),
                    'method' => 'post'
                ])
                    @dialog([
                        'title' => __('messages.projects.students.dialogs.create_title'),
                        'attrs' => [
                            'id' => 'dialog-project-student-create'
                        ],
                        'component' => [
                            'view' => 'project::inputs.project-student-create',
                            'props' => [
                                'studentMembers' => $studentMembers
                            ],
                        ],
                        'footer' => [
                            'buttonAccept' => [
                                'text' => __('actions.create'),
                                'attrs' => [
                                    'type' => 'submit'
                                ]
                            ],
                            'buttonCancel' => [
                                'text' => __('actions.cancel'),
                                'attrs' => [
                                    'type' => 'button'
                                ]
                            ]                        
                        ]
                    ]) @enddialog                
                @endform
            @endcan
        @endcell
    @endgridWithInner
@endsection
