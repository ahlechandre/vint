<div class="count{{ isset($trending) ? " count--trending-{$trending}" : '' }}">
  <div class="count__body">
    @if ($icon ?? false)
      <div class="count__header">
        <i class="material-icons count__icon">{{ $icon }}</i>    
      </div>
    @endif

    <div class="count__primary">
      <h3 class="count__value mdc-typography--headline2 typography--mono">{{ $value }}</h3>
      <p class="count__title mdc-typography--subtitle2 typography--mono">{{ $title }}</p>
    </div>
    <div class="count__secondary">
      @if (isset($trendingValue) && isset($trendingIcon))
        <div class="count__trending">
          <span class="count__trending-value">{{ $trendingValue }}</span>
          <i class="count__trending-icon material-icons">{{ $trendingIcon }}</i>
        </div>
      @endif
  
    </div>    
  </div>

  @if ($actions ?? false)
    <div class="count__actions">
      @foreach ($actions as $action)
          @if ($action['button'] ?? false)
            @button($action['button']) @endbutton        
          @elseif ($action['iconButton'] ?? false)
            @iconButton($action['iconButton']) @endiconButton          
          @endif
      @endforeach
    </div>
  @endif
</div>