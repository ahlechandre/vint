<aside class="mdc-drawer drawer mdc-drawer--temporary mdc-typography">
  <nav class="mdc-drawer__drawer">
    <header class="mdc-drawer__header drawer__header">
      <div class="mdc-drawer__header-content drawer__header-content">
        <h4 class="mdc-typography--headline6 drawer__header-content-primary">
          {{ $title }}
        </h4>
        <p class="mdc-typography--body1 drawer__header-content-secondary">
          {{ $subtitle }}
        </p>
      </div>
    </header>
    <nav id="icon-with-text-demo" class="mdc-drawer__content mdc-list">
      @foreach($items as $item)
        <a class="mdc-list-item{{ $item['isActive'] ? ' mdc-list-item--activated' : '' }}" {{ setAttributes($item['attrs']) }}>
          <i class="material-icons mdc-list-item__graphic" aria-hidden="true">{{ $item['icon'] }}</i>{{ $item['text'] }}
        </a>
      @endforeach
    </nav>
  </nav>
</aside>