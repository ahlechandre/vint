<div class="menu mdc-menu mdc-menu-surface{{ set_classes($classes ?? []) }}" tabindex="-1"{{ set_attrs($attrs ?? []) }}>
    @list(
        component_with_props(
            component_with_attrs(
                component_with_classes($list, [
                    'mdc-menu__items'
                ]),
                [
                    'role' => 'menu',
                    'aria-hidden' => 'true'
                ]
            ),
            [
                'isMenu' => true,
            ]
        )
    )
    @endlist
</div>