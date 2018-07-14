<div class="expandable">
    @layoutGridInner
        @cell([
            'when' => ['default' => 12],
            'modifiers' => ["mdc-layout-grid--align-{$buttonAlign}"]
        ])
            @button(array_merge($button, [
                    'modifiers' => ['expandable__activation']
                ]
            )) @endbutton
        @endcell

        @cell([
            'when' => ['default' => 12]
        ])
            <div class="expandable__content">
                {{ $slot }}
            </div>
        @endcell
    @endlayoutGridInner
</div>
