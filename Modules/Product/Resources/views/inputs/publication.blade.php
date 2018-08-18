@layoutGridInner
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
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        <h3>Projetos</h3>

        @foreach($projects as $project)
            @checkbox([
                'label' => $project->name,
                'attrs' => [
                    'name' => 'projects[]',
                    'value' => $project->id,
                    'checked' => $projectsId ?
                        in_array($project->id, $projectsId) : false
                ],
            ]) @endcheckbox
        @endforeach
    @endcell
    
    {{-- Membros --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        <h3>Autores</h3>

        @foreach($members as $member)
            @checkbox([
                'label' => $member->user->name,
                'attrs' => [
                    'name' => 'members[]',
                    'value' => $member->user_id,
                    'checked' => $membersUserId ?
                        in_array($member->user_id, $membersUserId) : false
                ],
            ]) @endcheckbox
        @endforeach
    @endcell       

@endlayoutGridInner