<div class="tab-bar mdc-tab-bar{{ set_classes($classes ?? []) }} tab-bar--with-border" role="tablist" aria-label="Navigation" data-mdc-auto-init="MDCTabBar"{{ set_attrs($attrs ?? []) }}>
  <div class="tab-scroller mdc-tab-scroller">
    <div class="mdc-tab-scroller__scroll-area">
      <div class="mdc-tab-scroller__scroll-content">
        @foreach($tabs as $tab)
          @if (!isset($tab['ignore']) || !$tab['ignore'])
            @tab($tab) @endtab        
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>