@dialog([
    'activation' => $activation,
    'title' => $title,
    'attrs' => [
        'id' => $dialogId,
    ],
    'cancel' => [
        'text' => __('actions.cancel'),
        'attrs' => [
            'type' => 'button'
        ],
    ],
    'accept' => [
        'text' => $acceptText,
        'attrs' => [
            'type' => 'submit'
        ],
    ],        
])
    @layoutGridInner
        {{-- Descrição --}}
        @cell([
            'when' => [
                'desktop' => 12,
                'tablet' => 8,
            ]
        ])
            <p class="mdc-typography--subtitle1">
                {{ $description }}
            </p>
        @endcell

        {{-- Expira em --}}
        @cell([
            'when' => [
                'desktop' => 4,
                'tablet' => 8,
            ]
        ])
            @textfield([
                'label' => __('attrs.expires_at'),
                'attrs' => [
                    'type' => 'date',
                    'name' => 'expires_at',
                    'required' => '',
                    'value' => $expiresAt,
                    'id' => 'textfield-group-invite-expires-at',
                ],
            ]) @endtextfield
        @endcell

    @endlayoutGridInner
@enddialog