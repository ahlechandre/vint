<div {{ setAttributes($attrs ?? []) }} class="layout-grid mdc-layout-grid{{ setModifiers($modifiers ?? null) }}">
  <div class="mdc-layout-grid__inner">
    {{ $slot }}
  </div>
</div>