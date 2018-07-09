<div class="mdc-text-field mdc-text-field--textarea" data-mdc-auto-init="MDCTextField">
  <textarea {{ setAttributes($attrs ?? null) }} class="mdc-text-field__input">{{ $attrs['value'] ?? null }}</textarea>
  <label for="{{ $attrs['id'] ?? null }}" class="mdc-floating-label">{{ $label }}</label>
</div>

@if ($helperText ?? false)
  @component('material.textfield-helper-text', [
    'isPersistent' => $helperText['isPersistent'] ?? false,
    'isValidation' => $helperText['isValidation'] ?? false,
    'message' => $helperText['message'],
  ]) @endcomponent
@endif

{{-- 
  @component('material.textfield-textarea', [
    'label' => 'My textarea',
    'attrs' => [
      'name' => 'textarea-name',
      'id' => 'textarea-id',
      'value' => 'content here',
    ],
  ]) @endcomponent
 --}}
