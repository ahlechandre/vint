<div class="snackbar mdc-snackbar{{ set_classes($classes ?? []) }}"
     aria-live="assertive"
     aria-atomic="true"
     aria-hidden="true"
     {{ set_attrs($attrs ?? []) }}>
  <div class="mdc-snackbar__text"></div>
  <div class="mdc-snackbar__action-wrapper">
    <button type="button" class="mdc-snackbar__action-button"></button>
  </div>
</div>