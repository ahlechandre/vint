<div class="select mdc-typography select--select2{{ set_classes($componentClasses ?? []) }}"{{ set_attrs($componentAttrs ?? []) }}>
    <label>{{ $label }}</label>

    <select class="select__native-control{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
        @if ($options ?? false)
        @foreach($options as $option)
            <option {{ set_attrs($option['attrs'] ?? []) }}>{{ $option['text'] }}</option>
        @endforeach    
        @endif
    </select>    

</div>