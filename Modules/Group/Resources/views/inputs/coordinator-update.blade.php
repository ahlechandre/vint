@gridInner 
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
                'id' => "select-group-update-coordinator-{$coordinator->member_user_id}",
                'disabled' => '',
            ],
            'options' => [
                [
                    'text' => "{$coordinator->member->user->name} <{$coordinator->member->user->email}>",
                    'attrs' => [
                        'disabled' => '',
                        'selected' => '',
                        'value' => '...'
                    ]
                ]
            ]
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
            'label' => __('atts.is_vice_coordinator'),
            'attrs' => [
                'name' => 'is_vice',
                'id' => "checkbox-group-update-coordinator-is-vice-{$coordinator->member_user_id}",
                'checked' => $coordinator->pivot->is_vice ? true : false,
            ]
        ]) @endcheckbox
    @endcell        

@endgridInner