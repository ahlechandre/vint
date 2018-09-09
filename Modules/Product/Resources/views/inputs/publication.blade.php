@gridInner
    {{-- Referência --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textarea([
            'label' => __('attrs.reference'),
            'helperText' => $validations['reference'] ?? null,
            'attrs' => [
                'name' => 'reference',
                'id' => 'textfield-publication-link',
                'required' => '',
                'cols' => '100',
                'value' => $reference
            ],
        ]) @endtextarea
    @endcell

    {{-- URL --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.url'),
            'helperText' => $validations['url'] ?? null,
            'attrs' => [
                'type' => 'url',
                'name' => 'url',
                'id' => 'textfield-publication-url',
                'value' => $url
            ],
        ]) @endtextfield
    @endcell    

    {{-- Projetos --}}
    @cell
        @select2([
            'label' => __('resources.projects'),
            'componentAttrs' => [
                'id' => 'select-publication-projects',
                'data-vint-select2-placeholder' => __('attrs.publications.placeholders.projects'),
            ], 
            'helperText' => $validations['projects'] ?? null,
            'attrs' => [
                'multiple' => '',
                'name' => 'projects[]',
                'required' => ''
            ],
            'options' => $projects ?
                $projects->map(function ($project) {
                    return [
                        'text' => "{$project->name} / {$project->group->name}",
                        'attrs' => [
                            'value' => $project->id,
                            'selected' => '',
                        ],
                    ];
                }) : null
        ]) @endselect2    
    @endcell

    {{-- Membros --}}
    @cell
        @select2([
            'label' => __('resources.members'),
            'componentAttrs' => [
                'id' => 'select-publication-members',
                'data-vint-select2-placeholder' => __('attrs.publications.placeholders.members'),
            ], 
            'helperText' => $validations['members'] ?? null,
            'attrs' => [
                'multiple' => '',
                'name' => 'members[]'
            ],
            'options' => $members ?
                $members->map(function ($member) {
                    return [
                        'text' => "{$member->user->name} <{$member->user->email}>",
                        'attrs' => [
                            'value' => $member->user_id,
                            'selected' => '',
                        ],
                    ];
                }) : null
        ]) @endselect2
    @endcell

@endgridInner