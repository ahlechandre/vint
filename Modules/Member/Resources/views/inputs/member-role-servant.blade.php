@gridInner
    @cell
        {{ __('messages.settings.member.dialog.role_servant_body') }}
    @endcell

    {{-- SIAPE --}}
    @cell
        @textfield([
            'label' => __('attrs.siape'),
            'helperText' => [
                'isPersistent' => true,
                'isValidation' => false,
                'message' => __('messages.helpers.siape'),
            ],
            'attrs' => [
                'type' => 'text',
                'name' => 'servant[siape]',
                'required' => '',
                'pattern' => __('patterns.siape'),
                'id' => 'textfield-member-servant-siape',
                'value' => $member->servant->siape ?? null
            ]
        ]) @endtextfield
    @endcell

    {{-- É professor --}}
    @cell
        @checkbox([
            'label' => __('attrs.is_professor'),
            'attrs' => [
                'type' => 'text',
                'name' => 'servant[is_professor]',
                'id' => 'textfield-member-servant-is-professor',
                'checked' => isset($member->servant) ?
                    (
                        $member->servant->is_professor ? true : false
                    ) : false
            ]
        ]) @endcheckbox
    @endcell
@endgridInner