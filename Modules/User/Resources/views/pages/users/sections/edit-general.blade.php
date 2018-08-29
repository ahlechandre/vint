@form([
    'action' => url("users/{$userToEdit->id}"),
    'method' => 'put',
    'attrs' => [
        'id' => 'form-user'
    ],
    'withCancel' => true,
    'withSubmit' => true,
    'inputs' => [
        'view' => 'user::inputs.user',
        'props' => [
            'name' => $userToEdit->name,
            'userTypeId' => $userToEdit->user_type_id,
            'username' => $userToEdit->username,
            'email' => $userToEdit->email,
            'isActive' => $userToEdit->is_active ? true : false,
            'userTypes' => $userTypes,
        ],
    ]
]) @endform