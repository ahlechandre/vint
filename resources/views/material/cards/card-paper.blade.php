@card(component_with_classes($card, [
    'card--paper'
]))
    <div class="card__primary mdc-ripple-surface" data-mdc-auto-init="MDCRipple">
        <div class="card__header">
            <h2 class="card__header-title mdc-typography--headline6">{{ $title }}</h2>
            <p class="card__header-subtitle mdc-typography--subtitle2">{{ $subtitle }}</p>
        </div>
        <div class="card__content">
            {{ $slot }}
        </div>    
    </div>
@endcard