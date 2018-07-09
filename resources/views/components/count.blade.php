<div class="ss-count{{ isset($trending) ? " ss-count--trending-{$trending}" : '' }}">
  <div class="ss-count__body">
    <div class="ss-count__primary">
      <h3 class="ss-count__value">{{ $value }}</h3>
      <p class="ss-count__title">{{ $title }}</p>
    </div>
    <div class="ss-count__secondary">
      @if (isset($trendingValue) && isset($trendingIcon))
        <div class="ss-count__trending">
          <span class="ss-count__trending-value">{{ $trendingValue }}</span>
          <i class="ss-count__trending-icon material-icons">{{ $trendingIcon }}</i>
        </div>
      @endif
  
      @if ($icon ?? false)
        <div class="material-icons ss-count__icon">{{ $icon }}</div>    
      @endif
    </div>    
  </div>

  @if ($actions ?? false)
    <div class="ss-count__actions">
      @foreach ($actions as $action)
          @component("material.{$action['type']}", $action['props']) @endcomponent
      @endforeach
    </div>
  @endif
</div>