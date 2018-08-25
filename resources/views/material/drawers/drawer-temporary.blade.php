<aside class="drawer mdc-drawer mdc-drawer--temporary mdc-typography{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
  <nav class="drawer__drawer mdc-drawer__drawer">
    <header class="drawer__header mdc-drawer__header">
      <div class="drawer__header-content mdc-drawer__header-content">
        <div class="drawer__header-title">
            <h2 class="drawer__header-title-text">{{ $header['title'] }}</h2>
            <p class="drawer__header-subtitle-text">{{ $header['subtitle'] }}</p>
        </div>
      </div>
    </header>

    @if ($listGroup ?? false)
      @listGroup(component_with_classes($listGroup, [
          'mdc-drawer__content', 'drawer__content'
      ])) @endlistGroup    
    @else
      @list(component_with_classes($list, [
          'mdc-drawer__content', 'drawer__content'
      ])) @endlist    
    @endif
  </nav>
</aside>