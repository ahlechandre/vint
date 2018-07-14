<form action="{{ $action }}" method="{{ strtolower($method) === 'get' ? 'get' : 'post' }}" {{ setAttributes($attrs ?? []) }}>
    @if (strtolower($method) !== 'get')
        {{-- CSRF Protection --}}
        @csrf  
        {{-- Emula método HTTP --}}
        @method($method)
    @endif
    
    {{-- Verifica se possui view com inputs --}}
    @if ($inputs ?? false)
        @component($inputs['__view'], array_merge(
            $inputs['props'] ?? [], [
                'isUpdate' => strtolower($method) === 'put',
                'validations' => array_map(function ($error) {
                    return [
                        'isPersistent' => true,
                        'isValidation' => true,
                        'message' => $error[0],
                    ];
                }, $errors->toArray())                
            ])
        )) @endcomponent
    @endif

    {{-- Inputs livres --}}
    {{ $slot }}

    @layoutGridInner
        {{-- Quebra de linha. --}}
        @cell(['when' => ['d' => 12]]) @endcell

        {{-- Cancelar --}}
        @if ($withCancel ?? false)
            @cell([
                'when' => [
                    'desktop' => 6,
                    'tablet' => 4,
                    'phone' => 2
                ]
            ]) 
                @buttonLink([
                    'text' => __('actions.cancel'),
                    'attrs' => [
                        'href' => $action
                    ],
                ]) @endbuttonLink    
            @endcell
        @endif

        {{-- Submeter --}}
        @if ($withSubmit ?? false)
            @cell([
                'when' => [
                    'desktop' => ($withCancel ?? false) ? 6 : 12,
                    'tablet' => 4,
                    'phone' => 2,
                ],
                'modifiers' => ['mdc-layout-grid--align-right']
            ])
                @button([
                    'text' => __('actions.save'),
                    'icon' => 'check',
                    'modifiers' => ['mdc-button--unelevated'],
                    'attrs' => [
                        'type' => 'submit'
                    ]
                ]) @endbutton
            @endcell
        @endif
    @endlayoutGridInner
</form>