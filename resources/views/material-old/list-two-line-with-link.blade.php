<nav class="list mdc-list mdc-list--two-line mdc-list--avatar-list{{ setModifiers($modifiers ?? null) }}">
  @foreach($items as $item)
    <a class="list-item mdc-ripple-surface mdc-list-item mdc-list--two-line" {{ setAttributes($item['attrs'] ?? []) }}>
        <span class="mdc-list-item__graphic material-icons" aria-hidden="true">
          {{ $item['icon'] }}
        </span>
      <span class="mdc-list-item__text">
        {{ $item['text'] }}
        <span class="mdc-list-item__secondary-text">
          {{ $item['secondaryText'] }}
        </span>
      </span>
      <span class="mdc-list-item__meta material-icons" aria-hidden="true">
        {{ $item['meta']['icon'] }}
      </span>
    </a>
  @endforeach
</nav>