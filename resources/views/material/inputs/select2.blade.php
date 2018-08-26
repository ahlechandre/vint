<div class="select select--select2">
  <select class="select__native-control{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    @if ($options ?? false)
      @foreach($options as $option)
          <option {{ set_attrs($option['attrs'] ?? []) }}>{{ $option['text'] }}</option>
      @endforeach    
    @endif
  </select>
</div>