@paginable([
    'collection' => $users,
    'items' => $users->map(function ($userToShow) {
        return [
            'icon' => material_icon('users'),
            'text' => $userToShow->name,
            'secondaryText' => $userToShow->created_at
                ->diffForHumans(),
            'attrs' => [
                'href' => url("/users/{$userToShow->id}")
            ],
            'meta' => [
                'icon' => material_icon('forward')
            ]
        ];
    }),
]) @endpaginable
