@gridInner
    {{-- Nome --}}
    @cell([
        'when' => ['d' => 12, 't' => 8, 'p' => 4]
    ])
        @textfield([
            'label' => __('attrs.name'),
            'helperText' => $validations['name'] ?? null,
            'attrs' => [
                'type' => 'text',
                'name' => 'name',
                'id' => 'textfield-group-name',
                'required' => '',
                'value' => $name
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
                'id' => 'textfield-group-description',
                'required' => '',
                'cols' => 100,
                'rows' => 6,
                'value' => $description
            ],
        ]) @endtextarea
    @endcell
@endgridInner