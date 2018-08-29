<a class="mdc-tab{{ isset($fullWidth) && $fullWidth ? '' : ' mdc-tab--min-width' }}{{ isset($active) && $active ? ' mdc-tab--active' : '' }}{{ set_classes($classes ?? []) }}" role="tab" tabindex="0"{{ set_attrs($attrs ?? []) }}>
    <span class="mdc-tab__content">
        @if ($icon ?? false)
            <span class="mdc-tab__icon material-icons" aria-hidden="true">{{ $icon }}</span>
        @endif

        <span class="mdc-tab__text-label">{{ $label }}</span>

        @if ($restrictIndicator ?? false)
            @tabIndicator([
                'active' => $active ?? false
            ]) @endtabIndicator        
        @endif
    </span>
    
    @if (!($restrictIndicator ?? false))
        @tabIndicator([
            'active' => $active ?? false
        ]) @endtabIndicator    
    @endif

    <span class="mdc-tab__ripple"></span>
</a>