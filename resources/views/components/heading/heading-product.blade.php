@heading([
    'pretitle' => __('resources.products'),
    'title' => __("messages.products.name", [
        'id' => $product->id
    ]),
    'tabBar' => [
        'tabs' => [
            [
                'active' => $tabActive === 'about',
                'label' => __('headlines.about'),
                'attrs' => [
                    'href' => url("products/{$product->id}")
                ]
            ],
            [
                'active' => $tabActive === 'projects',
                'label' => __('resources.projects'),
                'attrs' => [
                    'href' => url("products/{$product->id}/projects")
                ]
            ],            
        ]               
    ]
]) @endheading