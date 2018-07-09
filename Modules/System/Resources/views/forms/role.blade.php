@component('components.form-with-card', [
  'title' => $title,
  'subtitle' => $subtitle,
  'form' => [
      'action' => $formAction,
      'method' => $formMethod,
      'cancel' => [
          'text' => __('actions.cancel'),
          'attrs' => [
              'href' => $formCancelUrl
          ],
      ],
      'submit' => [
          'text' => __('actions.save'),
          'icon' => 'check',
          'modifiers' => ['mdc-button--unelevated'],
          'attrs' => [
              'type' => 'submit'
          ],
      ],
      'inputs' => array_merge([
          [
              'material' => 'textfield',
              'when' => ['default' => 12],
              'validation' => $errors->get('name')[0] ?? null,
              'props' => [
                  'label' => __('columns.name'),
                  'attrs' => [
                      'name' => 'name',
                      'value' => $values['name'],
                      'id' => 'textfield-role-name',
                      'required' => '',
                  ],
              ],
          ],
          [
              'material' => 'textfield-textarea',
              'when' => ['default' => 12],
              'validation' => $errors->get('description')[0] ?? null,
              'props' => [
                  'label' => __('columns.description'),
                  'attrs' => [
                      'name' => 'description',
                      'value' => $values['description'],
                      'required' => '',
                      'cols' => 100,
                      'id' => 'textfield-role-description',
                  ],
              ],
          ],
          [
              'material' => 'switch',
              'when' => ['default' => 12],
              'props' => [
                  'label' => 'Inativo/Ativo',
                  'attrs' => [
                      'name' => 'is_active',
                      'checked' => $values['is_active'] ? true : false,
                      'id' => 'switch-role-is-active',
                  ],
              ],
          ],
      ], $props['resourcesAbilities']->map(function ($resourceAbilities) use ($values) {
          return [
              'material' => 'checkbox-group',
              'when' => ['default' => 12],
              'props' => [
                  'label' => $resourceAbilities['resource']->name,
                  'checkboxes' => $resourceAbilities['abilities']->map(function ($ability) use ($values) {
                      return [
                          'label' => $ability->method->name,
                          'attrs' => [
                              'name' => 'abilities[]',
                              'id' => "checkbox-role-abilities-{$ability->id}",
                              'value' => $ability->id,
                              'checked' => $values['abilities'] ? in_array($ability->id, $values['abilities']) : false,
                          ],
                      ];
                  })
              ],
          ];
      })->toArray()),
  ]
]) @endcomponent