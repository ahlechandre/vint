@list([
    'isNavigation' => true,
    'twoLine' => true,
    'items' => $groups->map(function ($group) {
        return [
            'text' => [
                'primary' => $group->name,
                'secondary' => $group->created_at
                    ->diffForHumans(),
            ],
            'meta' => [
                'icon' => __('icons.show'),
            ],
            'attrs' => [
                'href' => url("groups/{$group->id}")
            ]
        ];
    })
]) @endlist