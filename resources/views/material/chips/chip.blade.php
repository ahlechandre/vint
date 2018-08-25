<div class="mdc-chip">
    @if ($iconTrailing ?? false)
        <div class="mdc-chip__text">{{ $text ?? $slot }}</div>

        <i class="material-icons mdc-chip__icon mdc-chip__icon--trailing" tabindex="0" role="button">{{ $icon }}</i>
    @else
        <i class="material-icons mdc-chip__icon mdc-chip__icon--leading">{{ $icon }}</i>

        <div class="mdc-chip__text">{{ $text ?? $slot }}</div>
    @endif

</div>