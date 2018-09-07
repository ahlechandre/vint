@gridInner
    {{-- Descrição --}}
    @cell
        {{ __('messages.projects.students.create_body') }}
    @endcell

    {{-- Coordenador --}}
    @cell
        @select([
            'label' => __('resources.student'),
            'attrs' => [
                'id' => 'select-group-create-student',
                'required' => '',
                'name' => 'student_user_id'
            ],
            'options' => $studentMembers->map(function ($member) {
                return [
                    'text' => "{$member->user->name} <{$member->user->email}>",
                    'attrs' => [
                        'value' => $member->user_id
                    ]
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'disabled' => '',
                    'selected' => '',
                    'value' => ''
                ]
            ])
        ]) @endselect
    @endcell

    {{-- É bolsista --}}
    @cell
        @checkbox([
            'label' => __('attrs.is_scholarship'),
            'attrs' => [
                'name' => 'is_scholarship',
                'id' => 'checkbox-group-create-student-is-scholarship',
            ]
        ]) @endcheckbox
    @endcell

@endgridInner
