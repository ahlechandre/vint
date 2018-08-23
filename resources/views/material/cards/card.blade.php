<div class="card mdc-card{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    {{ $slot }}
    
    @if ($actions ?? false)
        <div class="mdc-card__actions">
            @if ($actions['buttons'] ?? false)
                <div class="mdc-card__action-buttons">
                    @foreach($actions['buttons'] as $action)
                        @button(component_with_classes($action, [
                            'mdc-card__action',
                            'mdc-card__action--button'
                        ])) @endbutton
                    @endforeach
                </div>
            @endif
            
            @if ($actions['icons'] ?? false)
                <div class="mdc-card__action-icons">
                    @foreach($actions['icons'] as $action)
                        @iconButton(component_with_classes($action, [
                            'mdc-card__action',
                            'mdc-card__action--icon'
                        ])) @endiconButton
                    @endforeach
                </div>
            @endif        
        </div>        

    @endif

</div>