@gridInner
    @foreach($permissionsByResource as $resourceGroup)
        @cell
            <h4>{{ $resourceGroup['resource']->name }}</h4>
        @endcell

        @cell
            @foreach ($resourceGroup['permissions'] as $permission)
                @checkbox([
                    'label' => $permission->action->name,
                    'attrs' => [
                        'id' => "group-role-{$groupRole->id}-permission-{$permission->id}",
                        'name' => 'permissions[]',
                        'value' => $permission->id,
                        'checked' => $groupRole->permissions
                            ->contains('id', $permission->id)
                    ],
                ]) @endcheckbox
            @endforeach
        @endcell
    @endforeach
@endgridInner
