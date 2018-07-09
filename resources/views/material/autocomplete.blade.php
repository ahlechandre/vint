<div {{ setAttributes($attrs ?? []) }} class="mdc-autocomplete{{ $isMultiple ? ' mdc-autocomplete--multiple' : ''}}" tabindex="0">  
  <div class="mdc-autocomplete__data">
    @component('material.textfield', array_merge(
      [
        'modifiers' => [
          'mdc-autocomplete__textfield',
        ],
      ],
      $textfield)
    ) @endcomponent
    <div class="mdc-autocomplete__results"></div>  
  </div>
  <div class="mdc-autocomplete__chips">
    @if ($values ?? false)
      @foreach($values as $value)
        <div class="mdc-chip">
          <div class="mdc-chip__text">
            {{ $value['text'] }}
          </div>
          
          <i class="material-icons mdc-chip__icon mdc-chip__icon--trailing"
            role="button" 
            tabindex="0">cancel</i>

          <input type="hidden" name="{{ $inputName }}" value="{{ $value['key'] }}">
        </div>
      @endforeach
    @endif
  </div>
</div>

{{--
  @autocomplete([
    'isMultiple' => true,
    'inputName' => 'producers',
    'attrs' => [
      'id' => 'autocomplete-dependencies-producers',
    ],
    'textfield' => [
      'label' => 'Produtores',
      'icon' => material_icon('producer'),
      'attrs' => [
        'type' => 'search',
        'autocomplete' => 'off', 
        'id' => 'autocomplete-dependencies-producers-textfield', 
      ],
    ]
  ]) @endautocomplete
--}}
