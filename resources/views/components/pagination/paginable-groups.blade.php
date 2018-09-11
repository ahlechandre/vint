@paginable([
    'paginator' => $groups,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $groups->map(function ($group) {
            return [
                'icon' => __('icons.group'),
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
        }),                    
    ]
]) @endpaginable