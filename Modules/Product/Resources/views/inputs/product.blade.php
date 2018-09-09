@gridInner
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
    @cell
        @select2([
            'label' => __('resources.projects'),
            'componentAttrs' => [
                'id' => 'select-product-projects',
                'data-vint-select2-placeholder' => __('attrs.products.placeholders.projects'),
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
    
@endgridInner