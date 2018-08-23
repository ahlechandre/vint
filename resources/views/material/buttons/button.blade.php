@if ($isLink ?? false)
  <a class="button mdc-button{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
    @if ($icon ?? false)
      @icon([
        'classes' => ['mdc-button__icon']
      ]){{ $icon }}@endicon
    @endif

    {{ $text ?? $slot }}
  </a>
@else
  <button class="button mdc-button{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }} data-mdc-auto-init="MDCRipple">
    @if ($icon ?? false)
      @icon([
        'classes' => ['mdc-button__icon']
      ]){{ $icon }}@endicon
    @endif

    {{ $text ?? $slot }}
  </button>
@endif