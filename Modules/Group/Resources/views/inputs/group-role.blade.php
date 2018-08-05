@dialog([
    'activation' => $activation,
    'title' => $title,
    'attrs' => [
        'id' => $dialogId,
    ],
    'cancel' => [
        'text' => __('actions.cancel'),
        'attrs' => [
            'type' => 'button'
        ],
    ],
    'isScrollable' => true,
    'accept' => [
        'text' => $acceptText,
        'attrs' => [
            'type' => 'submit'
        ],
    ],        
])
    @layoutGridInner
        {{-- Descrição --}}
        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8,
            ]
        ])
            <p class="mdc-typography--subtitle1">
                {!! nl2br($description) !!}
            </p>
        @endcell
        
        @foreach($permissionsByResources as $permissionsByResource)
            @cell
                <h4 class="mdc-typography--headline6">
                    {{ $permissionsByResource['resource']->name }}
                </h4>

                <div>
                    @foreach($permissionsByResource['permissions'] as $permission)
                        @checkbox([
                            'label' => $permission->action->name,
                            'attrs' => [
                                'name' => 'permissions[]',
                                'value' => $permission->id,
                                'id' => "checkbox-group-role-{$groupRole->id}-permission-{$permission->id}",
                                'checked' => $groupRole->permissions->contains('id', $permission->id)
                            ],
                        ]) @endcheckbox
                    @endforeach    
                </div>
            @endcell
        @endforeach
    @endlayoutGridInner
@enddialog