@gridInner
    @cell
        {{ __('dialogs.coordinators.create_body') }}
    @endcell

    {{-- Coordenador --}}
    @cell([
        'when' => [
            'desktop' => 12,
            'tablet' => 8,
        ]
    ])
        @select([
            'label' => __('resources.servant'),
            'attrs' => [
                'id' => 'select-group-create-coordinator',
                'required' => '',
                'name' => 'coordinator_user_id'
            ],
            'options' => $servantMembers->map(function ($member) {
                return [
                    'text' => "{$member->user->name} <{$member->user->email}>",
                    'attrs' => [
                        'value' => $member->user_id
                    ]
                ];
            })->prepend([
                'text' => '',
                'attrs' => [
                    'disabled' => '',
                    'selected' => '',
                    'value' => ''
                ]
            ])
        ]) @endselect
    @endcell

    {{-- É vice --}}
    @cell([
        'when' => [
            'desktop' => 12,
            'tablet' => 8,
        ]
    ])
        @checkbox([
            'label' => __('attrs.is_vice_coordinator'),
            'attrs' => [
                'name' => 'is_vice',
                'id' => 'checkbox-group-create-coordinator-is-vice',
            ]
        ]) @endcheckbox
    @endcell        

@endgridInner