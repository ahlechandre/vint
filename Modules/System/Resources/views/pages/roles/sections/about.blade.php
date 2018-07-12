@listTwoLine([
    'items' => [
        [
            'icon' => material_icon('name'),
            'text' => __('attrs.name'),
            'secondaryText' => $role->name,
        ],
        [
            'icon' => material_icon('description'),
            'text' => __('attrs.description'),
            'secondaryText' => $role->description ?? 'Sem descrição'
        ],
        [
            'icon' => material_icon('is_active'),
            'text' => __('attrs.is_active'),
            'secondaryText' => $role->is_active ? 'Sim' : 'Não',
        ],
        [
            'icon' => material_icon('created_at'),
            'text' => __('attrs.created_at'),
            'secondaryText' => $role->created_at
                ->format(__('dates.format')),
        ],
        [
            'icon' => material_icon('updated_at'),
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