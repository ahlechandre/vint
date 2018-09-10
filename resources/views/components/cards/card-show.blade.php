@card
    @list([
        'twoLine' => true,
        'nonInteractive' => true,
        'items' => array_map(function ($item) {
            return [
                'text' => [
                    'primary' => $item['label'],
                    'secondary' => $item['value'] ?? __('messages.attrs.empty'),
                ],
                'meta' => isset($item['link']) ? [
                    'iconButton' => [
                        'isLink' => true,
                        'icon' => __('icons.show'),
                        'attrs' => [
                            'href' => $item['link'],
                            'title' => __('actions.show')
                        ],
                    ]
                ] : null
            ];
        }, array_filter($data, function ($item) {
            return !isset($item['ignore']) || !$item['ignore'];
        }))
    ]) @endlist
@endcard