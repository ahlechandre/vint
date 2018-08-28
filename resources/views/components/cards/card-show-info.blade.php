@card
    @cardContent
        @gridInner
            @foreach($cells as $cell)
                @cell
                    @gridInner
                        @if ($cell['left'] ?? false)
                            @cell([
                                'when' => ['d' => 6, 't' => 4, 'p' => 4],
                                'classes' => ['mdc-layout-grid--align-left']
                            ])
                                @list($cell['left']['list']) @endlist
                            @endcell
                        @endif

                        @if ($cell['right'] ?? false)
                            @cell([
                                'when' => ['d' => 6, 't' => 4, 'p' => 4],
                                'classes' => ['layout-grid--align-right-tablet']
                            ])
                                @list($cell['right']['list']) @endlist
                            @endcell                        
                        @endif

                        @if ($cell['list'] ?? false)
                            @cell
                                @list($cell['list']) @endlist
                            @endcell
                        @endif
                    @endgridInner
                @endcell            
            @endforeach
        @endgridInner
        {{ $slot }}
    @endcardContent
@endcard