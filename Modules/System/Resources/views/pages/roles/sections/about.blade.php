@listTwoLine([
    'items' => [
        [
            'icon' => __('material_icons.name'),
            'text' => __('attrs.name'),
            'secondaryText' => $role->name,
        ],
        [
            'icon' => __('material_icons.description'),
            'text' => __('attrs.description'),
            'secondaryText' => $role->description ?? 'Sem descrição'
        ],
        [
            'icon' => __('material_icons.is_active'),
            'text' => __('attrs.is_active'),
            'secondaryText' => $role->is_active ? 'Sim' : 'Não',
        ],
        [
            'icon' => __('material_icons.created_at'),
            'text' => __('attrs.created_at'),
            'secondaryText' => $role->created_at
                ->format(__('dates.format')),
        ],
        [
            'icon' => __('material_icons.updated_at'),
            'text' => __('attrs.updated_at'),
            'secondaryText' => $role->updated_at
                ->format(__('dates.format')),
        ],
    ]
]) @endlistTwoLine 

@if ($user->can('update', $role))
    @fab([
        'icon' => 'edit',
        'label' => 'Editar papel',
        'modifiers' => ['fab--fixed'],
        'attrs' => [
            'href' => url("/roles/{$role->id}/edit"),
            'title' => 'Editar papel',
            'alt' => 'Editar papel',
        ],
    ]) @endfab
@endif