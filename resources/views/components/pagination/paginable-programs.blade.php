@paginable([
    'paginator' => $programs,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $programs->map(function ($program) {
            return [
                'icon' => __('icons.program'),
                'text' => [
                    'primary' => $program->name,
                    'secondary' => $program->created_at
                        ->diffForHumans(),
                ],
                'meta' => [
                    'icon' => __('icons.show'),
                ],
                'attrs' => [
                    'href' => url("programs/{$program->id}")
                ]
            ];
        }),
    ]
]) @endpaginable