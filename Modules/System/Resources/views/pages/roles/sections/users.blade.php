@paginable([
    'collection' => $users,
    'items' => $users->map(function ($userToShow) {
        return [
            'icon' => __('material_icons.users'),
            'text' => $userToShow->name,
            'secondaryText' => $userToShow->created_at
                ->diffForHumans(),
            'attrs' => [
                'href' => url("/users/{$userToShow->id}")
            ],
            'meta' => [
                'icon' => __('material_icons.forward')
            ]
        ];
    }),
]) @endpaginable
