@paginable([
    'paginator' => $members,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $members->map(function ($member) {
            return [
                'icon' => __('icons.member'),
                'text' => [
                    'primary' => $member->user->name,
                    'secondary' => $member->created_at
                        ->diffForHumans(),
                ],
                'meta' => [
                    'icon' => __('icons.show'),
                ],
                'attrs' => [
                    'href' => url("members/{$member->user_id}")
                ]
            ];
        }),                    
    ]
]) @endpaginable