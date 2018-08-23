<div class="mdc-form-field">
  <div class="mdc-checkbox">
    <input type="checkbox"
           class="mdc-checkbox__native-control"
           {{ setAttributes($attrs ?? null) }}
           {{ isset($isChecked) && $isChecked ? 'checked' : '' }}/>
    <div class="mdc-checkbox__background">
      <svg class="mdc-checkbox__checkmark"
           viewBox="0 0 24 24">
        <path class="mdc-checkbox__checkmark-path"
              fill="none"
              stroke="white"
              d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
      </svg>
      <div class="mdc-checkbox__mixedmark"></div>
    </div>
  </div>
  <label for="{{ $attrs['id'] ?? null }}">{{ $label ?? null }}</label>
</div>

{{-- 
  @component('material.checkbox', [
    'label' => 'My checkbox',
    'attrs' => [
      'name' => 'checkbox-1',
      'id' => 'checkbox-1',
      'required' => '',
    ],
  ]) @endcomponent 
--}}