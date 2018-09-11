@paginable([
    'paginator' => $products,
    'withoutSearch' => $withoutSearch ?? false,
    'withoutActions' => $withoutActions ?? false,
    'list' => [
        'isNavigation' => true,
        'twoLine' => true,
        'items' => $products->map(function ($product) {
            return [
                'icon' => __('icons.product'),
                'text' => [
                    'primary' => $product->title,
                    'secondary' => $product->created_at
                        ->diffForHumans(),
                ],
                'meta' => [
                    'icon' => __('icons.show'),
                ],
                'attrs' => [
                    'href' => url("products/{$product->id}")
                ]
            ];
        }),                    
    ]
]) @endpaginable