<div class="resource-filter">
    @layoutGridInner
        @foreach($filters as $filter)
            @cell([
                'when' => [
                    'desktop' => 4,
                    'tablet' => 4,
                ]
            ])
                <p class="resource-filter__label">{{ $filter['label'] }}</p>

                <nav class="resource-filter__navigation">
                    @foreach ($filter['items'] as $item)
                <a class="resource-filter__navigation-item{{ $item['isActive'] ? ' resource-filter__navigation-item--activated' : '' }}" {{ setAttributes($item['attrs']) }}>
                            {{ $item['text'] }}
                            @if ($item['isActive'])
                                <i class="material-icons resource-filter__navigation-icon">close</i>
                            @endif
                        </a>
                    @endforeach    
                </nav>
            @endcell
        @endforeach
    @endlayoutGridInner
</div>
