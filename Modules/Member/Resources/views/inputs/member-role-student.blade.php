@gridInner
    @cell
        {{ __('messages.settings.member.dialog.role_student_body') }}
    @endcell

    {{-- RGA --}}
    @cell
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
                'value' => $member->student->rga ?? null
            ]
        ]) @endtextfield
    @endcell

@endgridInner