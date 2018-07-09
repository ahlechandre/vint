<div class="text-field mdc-text-field{{ setModifiers($modifiers ?? null) }}" data-mdc-auto-init="MDCTextField">
  @if ($icon ?? false)
  <i class="material-icons mdc-text-field__icon" role="button">{{ $icon }}</i>  
  @endif
  <input {{ setAttributes($attrs ?? null) }} class="mdc-text-field__input text-field__input">
  @if ($label ?? false)
  <label class="mdc-floating-label{{ setModifiers($labelModifiers ?? null) }}" for="{{ $attrs['id'] ?? null }}">{{ $label }}</label>  
  @endif
  <div class="mdc-line-ripple"></div>
</div>

@if ($helperText ?? false)
  @component('material.textfield-helper-text', [
    'isPersistent' => $helperText['isPersistent'] ?? false,
    'isValidation' => $helperText['isValidation'] ?? false,
    'message' => $helperText['message'],
  ]) @endcomponent
@endif

{{-- 
  @component('material.textfield', [
    'label' => 'Label textfield',
    'attrs' => [
      'name' => 'textfield-name',
      'id' => 'textfield-id',
      'required' => '',
    ],
  ]) @endcomponent
 --}}