<div class="text-field mdc-text-field mdc-text-field--box" data-mdc-auto-init="MDCTextField">
  <input class="text-field__input mdc-text-field__input{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
  <label class="mdc-floating-label" for="{{ $attrs['id'] }}">{{ $label }}</label>
  <div class="mdc-line-ripple"></div>
</div>