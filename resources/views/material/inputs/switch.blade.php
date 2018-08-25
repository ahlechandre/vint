<div class="switch mdc-switch" data-mdc-auto-init="MDCSwitch">
    <div class="mdc-switch__track"></div>
    <div class="mdc-switch__thumb-underlay">
        <div class="mdc-switch__thumb">
            <input type="checkbox" class="mdc-switch__native-control{{ set_classes($classes ?? []) }}" role="switch"{{ set_attrs($attrs ?? []) }}>
        </div>
    </div>
</div>
<label for="{{ $attrs['id'] }}">{{ $label }}</label>