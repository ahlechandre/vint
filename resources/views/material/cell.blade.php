<div class="mdc-layout-grid__cell{{ isset($when) ? setMaterialCells($when) : ' mdc-layout-grid__cell--span-12' }}{{ setModifiers($modifiers ?? null) }}">
  {{ $slot }}
</div>
