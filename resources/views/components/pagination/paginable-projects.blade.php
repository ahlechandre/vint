@paginable([
    'paginator' => $projects,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $projects->map(function ($project) {
            return [
                'icon' => __('icons.project'),
                'text' => [
                    'primary' => $project->name,
                    'secondary' => $project->created_at
                        ->diffForHumans(),
                ],
                'meta' => [
                    'icon' => __('icons.show'),
                ],
                'attrs' => [
                    'href' => url("projects/{$project->id}")
                ]
            ];
        }),
    ]
]) @endpaginable