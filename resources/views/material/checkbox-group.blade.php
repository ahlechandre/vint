<div class="checkbox-group">
  <h3 class="mdc-typography--headline5 typography--form-group-title">{{ $label }}</h3>
  @foreach($checkboxes as $checkbox)
    @checkbox($checkbox) @endcheckbox
  @endforeach  
</div>