<div class="heading">
    @gridInner
        @cell([
            'when' => ['d' => 8, 't' => 6, 'p' => 4]
        ])
            <div class="heading__title">
                <h1 class="heading__title-text">{{ $title }}</h1>
            </div>
            <div class="heading__content">
                <p class="heading__content-text">{{ $content }}</p>
            </div>        
        @endcell

        @cell([
            'when' => ['d' => 4, 't' => 2, 'p' => 4],
            'classes' => ['mdc-layout-grid--align-right']
        ])
            <div class="heading__action">
                @if ($action['button'] ?? false)
                    @button(component_with_classes($action['button'], [
                        'heading__action-button'
                    ])) @endbutton
                @elseif ($action['shapeButton'] ?? false)
                    @shapeButton(component_with_classes($action['shapeButton'], [
                        'heading__action-shape-button'
                    ])) @endshapeButton                
                @endif
            </div>        
        @endcell
    @endgridInner
</div>