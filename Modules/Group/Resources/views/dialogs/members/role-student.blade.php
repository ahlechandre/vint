{{-- Diálogo --}}
@dialog([
    'activation' => $activation,
    'cancel' => [
        'text' => __('actions.cancel'),
        'attrs' => [
            'type' => 'button' 
        ],
    ],
    'accept' => [
        'text' => __('actions.update'),
        'attrs' => [
            'type' => 'submit'
        ],
    ],
    'attrs' => [
        'id' => 'dialog-member-role-student'
    ],
    'title' => __('messages.members.dialog.role_student_title')
])
    {{ __('messages.members.dialog.role_student_body') }}
    {{-- RGA --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.rga'),
            'helperText' => [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.rga'),
            ],
            'attrs' => [
                'type' => 'text',
                'name' => 'student[rga]',
                'required' => '',
                'pattern' => __('patterns.rga'),
                'id' => 'textfield-member-student-rga',
                'value' => $rga
            ]
        ]) @endtextfield
    @endcell
@enddialog
