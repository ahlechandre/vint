<form action="{{ $action }}" method="{{ $method === 'get' ? 'get' : 'post' }}" {{ setAttributes($attrs ?? []) }}>
  @if ($method !== 'get')
      {{-- CSRF Protection --}}
      @csrf  
      {{-- Emula método HTTP --}}
      @method($method)
  @endif

  @if ($inputsHidden ?? false)
      @foreach ($inputsHidden as $inputHidden)
          <input type="hidden" {{ setAttributes($inputHidden['attrs']) }}>
      @endforeach
  @endif
  
  @component('material.layout-grid-inner')
      @if ($inputs ?? false)
          {{-- Inputs --}}
          @foreach($inputs as $input)
  
          @if (!isset($input['ignore']) || !$input['ignore'])
              @component('material.cell', [
              'when' => $input['when']
              ])
                  @component(
                      "material.{$input['material']}", (
                          isset($input['validation']) && $input['validation'] ? 
                              array_merge(
                                  $input['props'],
                                  [
                                  'helperText' => [
                                      'isValidation' => true,
                                      'isPersistent' => true,
                                      'message' => $input['validation'],
                                  ],
                              ]) : $input['props']
                      )
                  ) @endcomponent
              @endcomponent
          @endif
          @endforeach
      
      @endif
  
      @if ($inputsGroups ?? false)
          @foreach ($inputsGroups as $inputsGroup)
              {{-- Label --}}
              @component('material.cell', [
                  'when' => ['default' => 12]
              ])
                  <h3 class="typography--form-group-title mdc-typography--headline5">{{ $inputsGroup['title'] }}</h3>
                  <p class="typography--form-group-subtitle mdc-typography--subtitle2">{{ $inputsGroup['subtitle'] }}</p>
              @endcomponent

              {{-- Inputs --}}
              @foreach($inputsGroup['inputs'] as $input)
                  @component('material.cell', [
                      'when' => $input['when']
                  ])
                      @component(
                      "material.{$input['material']}",
                      (
                          isset($input['validation']) && $input['validation'] ? array_merge(
                          $input['props'],
                          [
                              'helperText' => [
                                  'isValidation' => true,
                                  'isPersistent' => true,
                                  'message' => $input['validation'],
                              ],
                          ]
                          ) : $input['props']
                      )
                      ) @endcomponent
                  @endcomponent
              @endforeach
                      
          @endforeach
      @endif

      {{-- Linha quebrada --}}
      @component('material.cell', [
          'when' => [
          'default' => 12,
          ]
      ]) @endcomponent
  
      {{-- Cancelar --}}
      @if ($cancel ?? false)
          @component('material.cell', [
          'when' => [
              'desktop' => 6,
              'tablet' => 4,
              'phone' => 2,
          ]
          ])
              @component('material.button-link', $cancel) @endcomponent    
          @endcomponent
      @endif
  
      {{-- Submeter --}}
      @if ($submit ?? false)
          @component('material.cell', [
          'when' => [
              'desktop' => isset($cancel) ? 6 : 12,
              'tablet' => 4,
              'phone' => 2,
          ],
          'modifiers' => ['mdc-layout-grid--align-right'],
          ])
          @component('material.button', $submit) @endcomponent
          @endcomponent    
      @endif

  @endcomponent
</form>