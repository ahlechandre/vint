<div class="text-field mdc-text-field mdc-text-field--textarea mdc-text-field--box" data-mdc-auto-init="MDCTextField">
  <textarea class="mdc-text-field__input{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>{{ $attrs['value'] ?? $text ?? null }}</textarea>
  <label for="{{ $attrs['id'] }}" class="mdc-floating-label">{{ $label }}</label>
</div>