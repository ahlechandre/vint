<form action="{{ $action }}" method="{{ strtolower($method) === 'get' ? 'get' : 'post' }}" {{ set_attrs($attrs ?? []) }}>
    @if (strtolower($method) !== 'get')
        {{-- CSRF Protection --}}
        @csrf  
        {{-- Emula método HTTP --}}
        @method($method)
    @endif
    
    {{-- Verifica se possui view com inputs --}}
    @if ($inputs ?? false)
        @component($inputs['view'], array_merge(
            $inputs['props'] ?? [], [
                'isUpdate' => strtolower($method) === 'put',
                'validations' => array_map(function ($error) {
                    return [
                        'isPersistent' => true,
                        'isValidation' => true,
                        'text' => $error[0],
                    ];
                }, $errors->toArray())                
            ])
        )) @endcomponent
    @endif

    {{-- Inputs livres --}}
    {{ $slot }}

    @if ((isset($withSubmit) && $withSubmit) || (isset($withCancel) && $withCancel))
        @gridInner
            {{-- Quebra de linha. --}}
            @cell @endcell
            @cell @endcell

            {{-- Cancelar --}}
            @if ($withCancel ?? false)
                @cell([
                    'when' => ['d' => 6, 't' => 4, 'p' => 2],
                ])
                    @button([
                        'isLink' => true,
                        'text' => __('actions.cancel'),
                        'attrs' => [
                            'href' => $action
                        ],
                    ]) @endbutton
                @endcell
            @endif

            {{-- Submeter --}}
            @if ($withSubmit ?? false)
                @cell([
                    'when' => ['d' => 6, 't' => 4, 'p' => 2],
                    'classes' => ['mdc-layout-grid--align-right']
                ])
                    @button([
                        'text' => __('actions.save'),
                        'icon' => 'check',
                        'classes' => [
                            'mdc-button--outlined'
                        ],
                        'attrs' => [
                            'type' => 'submit'
                        ]
                    ]) @endbutton                    
                @endcell
            @endif
            
        @endgridInner
    
    @endif
</form>