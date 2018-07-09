<div class="mdc-text-field mdc-text-field--fullwidth{{ setModifiers($modifiers ?? null) }}" data-mdc-auto-init="MDCTextField">
  <input {{ setAttributes($attrs ?? null) }} class="mdc-text-field__input" placeholder="{{ $label }}">
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