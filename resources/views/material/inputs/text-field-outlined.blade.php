<div class="text-field mdc-text-field mdc-text-field--outlined{{ isset($helperText['isValidation']) && $helperText['isValidation'] ? ' mdc-text-field--invalid' : '' }}{{ isset($iconLeading) ? ' mdc-text-field--with-leading-icon' : '' }}{{ isset($iconTrailing) ? ' mdc-text-field--with-trailing-icon' : '' }}" data-mdc-auto-init="MDCTextField">
  @if ($iconLeading ?? false)
    @textfieldIcon([
      'icon' => $iconLeading
    ]) @endtextfieldIcon
  @endif
  <input class="text-field__input mdc-text-field__input{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
  <label class="mdc-floating-label{{ isset($floatingLabelAbove) && $floatingLabelAbove ? ' mdc-floating-label--float-above' : '' }}" for="{{ $attrs['id'] }}">{{ $label }}</label>

  @if ($iconTrailing ?? false)
    @textfieldIcon([
      'icon' => $iconTrailing
    ]) @endtextfieldIcon
  @endif
  
  <div class="mdc-notched-outline">
    <svg>
      <path class="mdc-notched-outline__path"/>
    </svg>
  </div>
  <div class="mdc-notched-outline__idle"></div>  
</div>

@if ($helperText ?? false)
  @textfieldHelperText($helperText) @endtextfieldHelperText
@endif
