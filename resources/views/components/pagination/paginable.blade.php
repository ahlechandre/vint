<div class="paginable{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>

    @gridInner
        @if (!isset($withoutSearch) || !$withoutSearch)
            {{-- Busca --}}
            @cell([
                'classes' => ['layout-grid--align-right-tablet']
            ])
                @form([
                    'method' => 'get',
                    'action' => url()->current(),
                ])
                    @textfieldOutlined([
                        'label' => __('actions.search'),
                        'iconLeading' => __('icons.search'),
                        'classes' => ['mdc-text-field--with-leading-icon'],
                        'attrs' => [
                            'type' => 'search',
                            'name' => 'q',
                            'id' => 'textfield-search',
                            'autocomplete' => 'off',
                            'value' => request()->query('q')
                        ]
                    ]) @endtextfieldOutlined
                @endform
            @endcell        
        @endif
        
        @if ($paginator->isEmpty())
            @cell
                {{-- Nenhum item --}}
                @component('components.pagination.paginator-empty', [
                    'search' => request()->query('q')
                ]) @endcomponent
            @endcell
        @else
            {{-- Lista --}}
            @cell
                @list(component_with_classes($list, [
                    'mdc-list--avatar-list'
                ])) @endlist
            @endcell

            @if (!isset($withoutActions) || !$withoutActions)
                {{-- Página anterior --}}
                @cell([
                    'when' => ['d' => 6, 't' => 4, 'p' => 2]
                ])
                    {{-- Página anterior --}}
                    @if ($paginator->previousPageUrl())
                        @button([
                            'isLink' => true,
                            'text' => __('headlines.previous_page'),
                            'attrs' => [
                                'href' => $paginator->appends(request()->query())
                                    ->previousPageUrl(),
                            ]
                        ]) @endbutton
                    @else
                        @button([
                            'text' => __('headlines.previous_page'),
                            'attrs' => [
                                'disabled' => ''
                            ]
                        ]) @endbutton
                    @endif

                @endcell

                {{-- Página próxima --}}
                @cell([
                    'when' => ['d' => 6, 't' => 4, 'p' => 2],
                    'classes' => ['mdc-layout-grid--align-right']
                ])
                    {{-- Próxima página --}}
                    @if ($paginator->nextPageUrl())
                        @button([
                            'isLink' => true,
                            'text' => __('headlines.next_page'),
                            'attrs' => [
                                'href' => $paginator->appends(request()->query())
                                    ->nextPageUrl(),
                            ]
                        ]) @endbutton
                    @else
                        @button([
                            'text' => __('headlines.next_page'),
                            'attrs' => [
                                'disabled' => ''
                            ]
                        ]) @endbutton
                    @endif
                @endcell            
            @endif
        @endif                
    @endgridInner
        
</div>