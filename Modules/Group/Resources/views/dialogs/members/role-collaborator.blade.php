{{-- Diálogo --}}
@dialog([
    'activation' => 'dialog-activation-member-role-collaborator',
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
        'id' => 'dialog-member-role-collaborator'
    ],
    'title' => __('messages.members.dialog.role_collaborator_title')
])
    {{ __('messages.members.dialog.role_collaborator_body') }}
@enddialog