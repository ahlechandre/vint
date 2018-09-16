@paginable([
    'paginator' => $members,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $members->map(function ($member) {
            return [
                'letter' => substr($member->user->name, 0, 1),
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