@listTwoLine([
    'items' => [
        [
            'icon' => material_icon('name'),
            'text' => __('columns.name'),
            'secondaryText' => $role->name,
        ],
        [
            'icon' => material_icon('description'),
            'text' => __('columns.description'),
            'secondaryText' => $role->description ?? 'Sem descrição'
        ],
        [
            'icon' => material_icon('is_active'),
            'text' => __('columns.is_active'),
            'secondaryText' => $role->is_active ? 'Sim' : 'Não',
        ],
        [
            'icon' => material_icon('created_at'),
            'text' => __('columns.created_at'),
            'secondaryText' => $role->created_at
                ->format(__('dates.format')),
        ],
        [
            'icon' => material_icon('updated_at'),
            'text' => __('columns.updated_at'),
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