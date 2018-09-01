<aside class="drawer mdc-drawer mdc-drawer--modal{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    <div class="mdc-drawer__header">
        <h3 class="mdc-drawer__title">{{ $header['title'] }}</h3>
        <h6 class="mdc-drawer__subtitle">{{ $header['subtitle'] }}</h6>
    </div>
    <div class="mdc-drawer__content">
        @if ($listGroup ?? false)
            @listGroup($listGroup) @endlistGroup    
        @else
            @list($list) @endlist    
        @endif
    </div>
  </aside>

<div class="mdc-drawer-scrim"></div>