@if ($isLink ?? false)
    <a class="fab mdc-fab{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
        @icon([
            'classes' => ['mdc-fab__icon']
        ]) {{ $icon }} @endicon
        
        @if ($label ?? false)
            <span class="mdc-fab__label">{{ $label }}</span>
        @endif
    </a>
@else
    <button class="fab mdc-fab{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
        @icon([
            'classes' => ['mdc-fab__icon']
        ]) {{ $icon }} @endicon

        @if ($label ?? false)
            <span class="mdc-fab__label">{{ $label }}</span>
        @endif
    </button>
@endif