<div class="paginable">
    @component('material.layout-grid-inner')
        @component('material.cell', [
            'when' => [
                'default' => 12
            ]
        ])            
            @if ($collection->isEmpty())
                <h3 class="mdc-typography--headline5">Nenhum item para mostrar</h3>
            @else
                <div class="card mdc-card">
                    @component('material.list-two-line-with-link', [
                        'modifiers' => [
                            'mdc-list--avatar-list-inverse',
                        ],
                        'items' => $items
                    ]) @endcomponent
                </div>        
            @endif

        @endcomponent

        @component('material.cell', [
            'when' => [
                'desktop' => 6,
                'tablet' => 4,
                'phone' => 2,
            ]
        ])
            @if ($collection->previousPageUrl())
                @component('material.button-link', [
                    'text' => 'Anterior',
                    'attrs' => [
                        'href' => $collection->appends(
                            request()->query()
                        )->previousPageUrl(),
                    ],
                ]) @endcomponent
            @else
                @component('material.button', [
                    'text' => 'Anterior',
                    'attrs' => [
                        'disabled' => '',
                    ],
                ]) @endcomponent
            @endif
        @endcomponent

        @component('material.cell', [
            'when' => [
                'desktop' => 6,
                'tablet' => 4,
                'phone' => 2,
            ],
            'modifiers' => ['mdc-layout-grid--align-right']
        ])
            @if ($collection->nextPageUrl())
                @component('material.button-link', [
                    'text' => 'Próximo',
                    'modifiers' => ['mdc-button--unelevated'],
                    'attrs' => [
                        'href' => $collection->appends(
                            request()->query()
                        )->nextPageUrl(),
                    ],
                ]) @endcomponent
            @else
                @component('material.button', [
                    'text' => 'Próximo',
                    'modifiers' => ['mdc-button--unelevated'],
                    'attrs' => [
                        'disabled' => '',
                    ],
                ]) @endcomponent
            @endif
        @endcomponent
    @endcomponent    
</div>