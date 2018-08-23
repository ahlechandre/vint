<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Protection --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">    
    <title>{{ config('app.name') }} @if (View::hasSection('title')) / @yield('title') @endif
    </title>
    {{-- Material icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    {{-- MDC + App --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body class="mdc-typography">
    {{-- Progresso linear --}}
    <div role="progressbar" class="mdc-linear-progress mdc-linear-progress--indeterminate linear-progress linear-progress--global">
      <div class="mdc-linear-progress__buffering-dots"></div>
      <div class="mdc-linear-progress__buffer"></div>
      <div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar">
        <span class="mdc-linear-progress__bar-inner"></span>
      </div>
      <div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar">
        <span class="mdc-linear-progress__bar-inner"></span>
      </div>
    </div>

    {{-- Barra de navegação --}}
    @component('material.top-app-bar-with-search', [
      // 'modifiers' => ['mdc-top-app-bar--fixed'],
      'title' => 'VINT',
      'breadcrumbs' => $breadcrumbs ?? null,
      'tabs' => $topAppBarTabs ?? null,
      'actions' => $topAppBarActions ?? [],
      'menu' => [
        'icon' => 'menu',
        'attrs' => [
          'href' => '#', 
          'id' => 'top-app-bar-menu',
        ]
      ]
    ]) @endcomponent

    {{-- Conteúdo da página --}}
    <main class="mdc-top-app-bar--fixed-adjust">
      @yield('main')
    </main>

    {{-- Drawer --}}
    @component('material.drawer-temporary', [
      'title' => $user->name,
      'subtitle' => $user->email,
      'items' => [
        [
          'text' => 'Dashboard',
          'icon' => 'dashboard',
          'isActive' => isActivePage('dashboard'),
          'attrs' => [
            'href' => url('dashboard'),
          ],
        ],
        [
          'text' => __('resources.users'),
          'icon' => __('material_icons.users'),
          'isActive' => isActivePage('users'),
          'attrs' => [
            'href' => url('users'),
          ],
        ],
        [
          'text' => __('resources.groups'),
          'icon' => __('material_icons.groups'),
          'isActive' => isActivePage('groups'),
          'attrs' => [
            'href' => url('groups'),
          ],
        ],
        [
          'text' => __('resources.members'),
          'icon' => __('material_icons.members'),
          'isActive' => isActivePage('members'),
          'attrs' => [
            'href' => url('members'),
          ],
        ],
        [
          'text' => __('resources.programs'),
          'icon' => __('material_icons.programs'),
          'isActive' => isActivePage('programs'),
          'attrs' => [
            'href' => url('programs'),
          ],
        ],
        [
          'text' => __('resources.projects'),
          'icon' => __('material_icons.projects'),
          'isActive' => isActivePage('projects'),
          'attrs' => [
            'href' => url('projects'),
          ],
        ],
        [
          'text' => __('resources.products'),
          'icon' => __('material_icons.products'),
          'isActive' => isActivePage('products'),
          'attrs' => [
            'href' => url('products'),
          ],
        ],
        [
          'text' => __('resources.publications'),
          'icon' => __('material_icons.publications'),
          'isActive' => isActivePage('publications'),
          'attrs' => [
            'href' => url('publications'),
          ],
        ],                   
        [
          'text' => __('actions.logout'),
          'icon' => 'exit_to_app',
          'isActive' => false,
          'attrs' => [
            'href' => url('logout'),
          ],
        ],        
      ], 
    ]) @endcomponent

    {{-- Snackbars --}}
    @if (session('snackbar')) 
      @component('material.snackbar', [
        'message' => session('snackbar'),
        'actionText' => 'OK',
      ]) @endcomponent
    @endif

    {{-- Validation --}}
    @if ($errors->any()) 
      @component('material.snackbar', [
        'message' => $errors->first(),
        'actionText' => 'OK',
      ]) @endcomponent
    @endif    
    
    {{-- MDC --}}
    <script src="{{ asset('js/material-components-web.js') }}"></script>
    {{-- App --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Scripts injetados por páginas --}}
    @yield('scripts')
  </body>
</html>
