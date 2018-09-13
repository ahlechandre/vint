<div class="select mdc-select mdc-select--box{{ isset($helperText['isValidation']) && $helperText['isValidation'] ? ' mdc-select--invalid' : '' }}" data-mdc-auto-init="MDCSelect">
  <select class="select__native-control mdc-select__native-control{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    @foreach($options as $option)
        <option {{ set_attrs($option['attrs'] ?? []) }}>{{ $option['text'] }}</option>
    @endforeach
  </select>
  <label class="mdc-floating-label">{{ $label }}</label>
  <div class="mdc-line-ripple"></div>
</div>

@if ($helperText ?? false)
  @textfieldHelperText($helperText) @endtextfieldHelperText
@endif
