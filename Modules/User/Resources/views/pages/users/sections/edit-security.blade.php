@form([
    'action' => url("users/{$userToEdit->id}/password"),
    'method' => 'put',
    'attrs' => [
        'id' => 'form-security'
    ],
    'withCancel' => true,
    'withSubmit' => true,
    'inputs' => [
        'view' => 'user::inputs.user-password'
    ]
]) @endform