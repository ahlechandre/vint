@layoutGridInner
    {{-- Pessoal --}}
    @cell([
        'when' => ['desktop' => 12]
    ])
        @card([
            'title' => __('resources.product'),
            'subtitle' => __('messages.products.about'),
            'modifiers' => ['mdc-card--outlined']
        ])
            @listTwoLine([
                'items' => [
                    [
                        'icon' => __('material_icons.title'),
                        'text' => __('attrs.title'),
                        'secondaryText' => $product->title
                    ],
                    [
                        'icon' => __('material_icons.description'),
                        'text' => __('attrs.description'),
                        'secondaryText' => $product->description
                    ],
                    [
                        'icon' => __('material_icons.url'),
                        'text' => __('attrs.url'),
                        'secondaryText' => $product->url ?? 'Não possui'
                    ],                    
                ]
            ]) @endlistTwoLine
        @endcard

        @if ($user->can('update', $product))
            @fab([
                'icon' => 'edit',
                'label' => __('messages.products.edit'),
                'modifiers' => ['fab--fixed'],
                'attrs' => [
                    'href' => url("/products/{$product->id}/edit"),
                    'title' => __('messages.products.edit'),
                    'alt' => __('messages.products.edit'),
                ],
            ]) @endfab        
        @endif
    @endcell

@endlayoutGridInner