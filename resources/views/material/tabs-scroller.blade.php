<div {{ setAttributes($attrs ?? []) }} class="mdc-tab-bar-scroller">
  <div class="mdc-tab-bar-scroller__indicator mdc-tab-bar-scroller__indicator--back">
    <a class="mdc-tab-bar-scroller__indicator__inner material-icons" href="#" aria-label="scroll back button">
      navigate_before
    </a>
  </div>
  <div class="mdc-tab-bar-scroller__scroll-frame">
    <nav id="my-scrollable-tab-bar" class="mdc-tab-bar mdc-tab-bar-scroller__scroll-frame__tabs">
      @foreach ($tabs as $tab)
      <a class="mdc-tab mdc-tab--with-icon-and-text{{ $tab['isActive'] ? ' mdc-tab--active' : ''}}" {{ setAttributes($tab['attrs'] ?? []) }}>
          {{ $tab['text'] }}
      </a>
      @endforeach
      <span class="mdc-tab-bar__indicator"></span>
    </nav>
  </div>
  <div class="mdc-tab-bar-scroller__indicator mdc-tab-bar-scroller__indicator--forward">
    <a class="mdc-tab-bar-scroller__indicator__inner material-icons" href="#" aria-label="scroll forward button">
      navigate_next
    </a>
  </div>
</div>