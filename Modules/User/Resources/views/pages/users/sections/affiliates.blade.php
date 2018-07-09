@paginable([
    'collection' => $affiliates,
    'items' => $affiliates->map(function ($affiliate) {
        return [
            'icon' => material_icon('affiliate'),
            'meta' => [
                'icon' => 'arrow_forward',
            ],
            'text' => $affiliate->name,
            'secondaryText' => $affiliate->created_at
                ->diffForHumans(),
            'attrs' => [
                'href' => url("/affiliates/{$affiliate->id}"),
            ],
        ];
    }),
]) @endpaginable

@if ($user->can('update', $userToShow))
    @fab([
        'icon' => 'edit',
        'label' => __('actions.edit'),
        'modifiers' => ['fab--fixed'],
        'attrs' => [
            'href' => url("/users/{$userToShow->id}/affiliates"),
            'title' => __('actions.edit'),
            'alt' => __('actions.edit'),
        ],
    ]) @endfab
@endif