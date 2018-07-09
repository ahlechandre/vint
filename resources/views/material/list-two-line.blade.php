<ul class="list mdc-list mdc-list--two-line mdc-list--avatar-list{{ setModifiers($modifiers ?? null) }}">
    @foreach($items as $item)
    <li class="list-item mdc-list-item mdc-list--two-line" {{ setAttributes($item['attrs'] ?? []) }}>
        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">
            {{ $item['icon'] }}
        </span>
        <span title="{{ $item['text'] }}" class="mdc-list-item__text">
            {{ $item['text'] }}
            <span title="{{ $item['secondaryText'] }}" class="mdc-list-item__secondary-text">
            {{ $item['secondaryText'] }}
            </span>
        </span>

        @if ($item['meta'] ?? null)
            <a {{ setAttributes($item['meta']['attrs'] ?? []) }} class="mdc-list-item__meta material-icons">
                {{ $item['meta']['icon'] }}
            </a>
        @endif

        @if ($item['metas'] ?? null)
            <span class="mdc-list-item__meta">
                @foreach ($item['metas'] as $meta)
                    <a {{ setAttributes($meta['attrs'] ?? []) }} class="mdc-list-item__meta material-icons">
                        {{ $meta['icon'] }}
                    </a>       
                @endforeach
            </span>
        @endif
    </li>
    @endforeach
</ul>