@card([
    'title' => __('headlines.auth'),
    'subtitle' => __('messages.auth.index'),
    'modifiers' => ['mdc-card--outlined']
])
    @listTwoLine([
        'modifiers' => ['mdc-list--non-interactive'],
        'items' => [
            [
                'icon' => material_icon('password'),
                'text' => __('attrs.password'),
                'secondaryText' => '•••••••••••••'
            ],
        ]
    ]) @endlistTwoLine
@endcard

@if ($user->can('update', $userToShow))
    @fab([
        'icon' => 'edit',
        'label' => __('actions.edit'),
        'modifiers' => ['fab--fixed'],
        'attrs' => [
            'href' => url("/users/{$userToShow->id}/password"),
            'title' => __('actions.edit'),
            'alt' => __('actions.edit'),
        ],
    ]) @endfab        
@endif