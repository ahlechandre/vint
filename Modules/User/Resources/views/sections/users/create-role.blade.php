@card([
    'title' => 'Papel',
    'subtitle' => 'Escolha o papel do novo usuário'
])
    @listTwoLineWithLink([
        'items' => $roles->map(function ($role) {
            return [
                'icon' => material_icon("role_{$role->slug}") ?? __('material_icons.role'),
                'text' => $role->name,
                'secondaryText' => $role->description,
                'attrs' => [
                    'href' => url("/users/create?role_id={$role->id}")
                ],
                'meta' => [
                    'icon' => __('material_icons.forward'),
                    'attrs' => [
                        'title' => 'Criar usuário'
                    ],
                ],
            ];
        }),
    ]) @endlistTwoLineWithLink
@endcard