<header class="top-app-bar mdc-top-app-bar{{ setModifiers($modifiers ?? null) }}">
  <div class="mdc-top-app-bar__row top-app-bar__row">
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
      <a {{ setAttributes($menu['attrs']) }} class="material-icons mdc-top-app-bar__navigation-icon">{{ $menu['icon'] }}</a>
      <span class="mdc-top-app-bar__title">{{ $title }}</span>
    </section>
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
      @foreach($actions as $action)
        <a class="material-icons mdc-top-app-bar__action-item" {{ setAttributes($action['attrs']) }}>{{ $action['icon'] }}</a>
      @endforeach
    </section>
  </div>
</header>