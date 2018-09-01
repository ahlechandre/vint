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

            @cell([
                'classes' => ['mdc-layout-grid--align-right']
            ])
                {{-- Cancelar --}}
                @if ($withCancel ?? false)
                    @button([
                        'isLink' => true,
                        'text' => __('actions.cancel'),
                        'attrs' => [
                            'href' => $action
                        ],
                    ]) @endbutton        
                @endif

                {{-- Submeter --}}
                @if ($withSubmit ?? false)
                    @button([
                        'text' => __('actions.save'),
                        'icon' => 'check',
                        'classes' => ['mdc-button--outlined'],
                        'attrs' => [
                            'type' => 'submit'
                        ]
                    ]) @endbutton
                @endif
            
            @endcell
        @endgridInner
    
    @endif
</form>