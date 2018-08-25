<div class="tab-bar mdc-tab-bar{{ set_classes($classes ?? []) }}" role="tablist" aria-label="Navigation" data-mdc-auto-init="MDCTabBar"{{ set_attrs($attrs ?? []) }}>
  <div class="mdc-tab-scroller">
    <div class="mdc-tab-scroller__scroll-area">
      <div class="mdc-tab-scroller__scroll-content">
        @foreach($tabs as $tab)
          @tab($tab) @endtab
        @endforeach
      </div>
    </div>
  </div>
</div>