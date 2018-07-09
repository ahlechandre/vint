<div class="mdc-form-field">
  <div class="mdc-switch">
    <input type="checkbox" class="mdc-switch__native-control" role="switch" {{ setAttributes($attrs ?? []) }}>
    <div class="mdc-switch__background">
      <div class="mdc-switch__knob"></div>
    </div>
  </div>
  <label for="{{ $attrs['id'] }}">{{ $label }}</label>
</div>