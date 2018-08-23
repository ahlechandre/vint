<div class="mdc-form-field">
  <div class="mdc-radio">
    <input class="mdc-radio__native-control" type="radio"
    {{ setAttributes($attrs ?? null) }}>
    <div class="mdc-radio__background">
      <div class="mdc-radio__outer-circle"></div>
      <div class="mdc-radio__inner-circle"></div>
    </div>
  </div>
  <label for="{{ $attrs['id'] ?? null }}">{{ $label ?? null }}</label>
</div>