@layoutGridInner
    {{-- Titulo --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.title'),
            'helperText' => $validations['title'] ?? null,
            'attrs' => [
                'type' => 'text',
                'name' => 'title',
                'id' => 'textfield-product-link',
                'required' => '',
                'value' => $title
            ],
        ]) @endtextfield
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
                'id' => 'textfield-product-url',
                'value' => $url
            ],
        ]) @endtextfield
    @endcell    

    {{-- Description --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textarea([
            'label' => __('attrs.description'),
            'helperText' => $validations['description'] ?? null,
            'attrs' => [
                'name' => 'description',
                'id' => 'textfield-product-description',
                'required' => '',
                'cols' => 100,
                'rows' => 6,
                'value' => $description
            ],
        ]) @endtextarea
    @endcell

    {{-- Projetos --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
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

@endlayoutGridInner