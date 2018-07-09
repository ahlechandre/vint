<div class="text-field mdc-text-field mdc-text-field--outlined{{ setModifiers($modifiers ?? null) }}" data-mdc-auto-init="MDCTextField">
  @if ($icon ?? false)
  <i class="material-icons mdc-text-field__icon" role="button">{{ $icon }}</i>  
  @endif
  <input {{ setAttributes($attrs ?? null) }} class="mdc-text-field__input">
  <label class="mdc-floating-label" for="{{ $attrs['id'] ?? null }}">{{ $label }}</label>
  
  <div class="mdc-notched-outline">
    <svg>
      <path class="mdc-notched-outline__path"/>
    </svg>
  </div>
  <div class="mdc-notched-outline__idle"></div>
</div>

@if ($helperText ?? false)
  @component('material.textfield-helper-text', [
    'isPersistent' => $helperText['isPersistent'] ?? false,
    'isValidation' => $helperText['isValidation'] ?? false,
    'message' => $helperText['message'],
  ]) @endcomponent
@endif
