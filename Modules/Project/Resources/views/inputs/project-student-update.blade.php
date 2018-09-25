@gridInner
    {{-- Coordenador --}}
    @cell
        @select([
            'label' => __('resources.student'),
            'attrs' => [
                'id' => "select-group-update-student-{$student->member_user_id}",
                'disabled' => '',
            ],
            'options' => [
                [
                    'text' => "{$student->member->user->name} <{$student->member->user->email}>",
                    'attrs' => [
                        'disabled' => '',
                        'selected' => '',
                        'value' => '...'
                    ]
                ]
            ]
        ]) @endselect
    @endcell

    {{-- É bolsista --}}
    @cell([
        'when' => [
            'desktop' => 12,
            'tablet' => 8,
        ]
    ])
        @checkbox([
            'label' => __('attrs.is_scholarship'),
            'attrs' => [
                'name' => 'is_scholarship',
                'id' => "checkbox-group-update-student-is-scholarship-{$student->member_user_id}",
                'checked' => $student->pivot->is_scholarship ? true : false,
            ]
        ]) @endcheckbox
    @endcell        

@endgridInner
