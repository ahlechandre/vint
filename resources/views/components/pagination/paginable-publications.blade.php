@paginable([
    'paginator' => $publications,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $publications->map(function ($publication) {
            return [
                'icon' => __('icons.publication'),
                'text' => [
                    'primary' => $publication->reference,
                    'secondary' => $publication->created_at
                        ->diffForHumans(),
                ],
                'meta' => [
                    'icon' => __('icons.show'),
                ],
                'attrs' => [
                    'href' => url("publications/{$publication->id}")
                ]
            ];
        }),
    ]
]) @endpaginable