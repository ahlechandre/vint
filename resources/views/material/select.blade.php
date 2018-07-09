<div class="select mdc-select">
  <select class="mdc-select__native-control" {{ setAttributes($attrs ?? null) }}>
    @foreach ($options as $option)
      <option {{ setAttributes($option['attrs'] ?? null) }}>
        {{ $option['text'] }}
      </option>
    @endforeach
  </select>
  <label class="mdc-floating-label">{{ $label }}</label>
  <div class="mdc-line-ripple"></div>
</div>

@if ($helperText ?? false)
  @component('material.textfield-helper-text', [
    'isPersistent' => $helperText['isPersistent'] ?? false,
    'isValidation' => $helperText['isValidation'] ?? false,
    'message' => $helperText['message'],
  ]) @endcomponent
@endif
