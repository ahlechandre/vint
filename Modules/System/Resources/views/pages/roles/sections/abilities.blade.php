@foreach ($abilities
->load('resource', 'method')
->groupBy('resource_id')
->map(function ($abilities) {
    return [
        'resource' => $abilities->first()->resource,
        'abilities' => $abilities,
    ];
}) as $resourceAbilities)
    @component('material.checkbox-group', [
        'label' => $resourceAbilities['resource']->name,
        'checkboxes' => $resourceAbilities['abilities']->map(function ($ability) use ($role) {
            return [
                'label' => $ability->method->name,
                'attrs' => [
                    'id' => "checkbox-ability-{$ability->id}",
                    'checked' => $role->abilities->contains('id', $ability->id),
                    'disabled' => true,
                ],
            ];
        }),
    ]) @endcomponent
@endforeach

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