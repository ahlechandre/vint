@if ($isLink ?? false)
    <a class="fab mdc-fab{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
        @if ($label ?? false)
            <span class="mdc-fab__label">{{ $label }}</span>
        @endif

        @icon([
            'classes' => ['mdc-fab__icon']
        ]) {{ $icon }} @endicon
    </a>
@else
    <button class="fab mdc-fab{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
        @if ($label ?? false)
            <span class="mdc-fab__label">{{ $label }}</span>
        @endif

        @icon([
            'classes' => ['mdc-fab__icon']
        ]) {{ $icon }} @endicon
    </button>
@endif