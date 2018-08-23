@if ($isLink ?? false)
  <a class="material-icons icon-button mdc-icon-button{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    {{ $icon ?? $slot }}
  </a>
@else
  <button class="material-icons icon-button mdc-icon-button{{ set_classes($classes ?? []) }}"{{ set_attrs($attrs ?? []) }}>
    {{ $icon ?? $slot }}
  </button>
@endif