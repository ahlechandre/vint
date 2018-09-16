<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF Protection --}}
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>{{ $title }}</title>
    {{-- Material icons --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono:400,500i" rel="stylesheet">
    {{-- MDC + App --}}
    <link rel="stylesheet" href="{{ asset('css/vint.css') }}">
  </head>
  <body class="mdc-typography mdc-theme theme typography">
    {{-- Top App Bar --}}
    @topAppBarHome([
      'searchVisible' => $searchVisible ?? false,
      'menu' => [
        'icon' => 'menu',
        'classes' => ['drawer-activation'],
        'attrs' => [
          'href' => '#',
          'data-drawer-activation' => 'drawer-modal-default',
          'data-vint-auto-init' => 'VintDrawerActivation'
        ]
      ],
      'title' => [
        'attrs' => [
          'href' => url('/')
        ],
        'text' => 'VINT',
      ]
    ]) @endtopAppBarHome

    @drawerModal([
      'attrs' => [
        'id' => 'drawer-modal-default',
      ],
      'header' => [
        'title' => 'VINT',
        'subtitle' => 'Computação Visual e Interativa',        
      ],
      'list' => [
        'isNavigation' => true,
        'items' => [
          [
            'dividerBefore' => true,
            'icon' => __('icons.login'),
            'text' => __('headlines.login'),
            'active' => is_active_page('login'),
            'attrs' => [
              'href' => url('/login')
            ],
          ],
          [
            'dividerBefore' => true,
            'icon' => __('icons.homepage'),
            'text' => __('headlines.homepage'),
            'active' => is_active_page('/'),
            'attrs' => [
              'href' => url('/')
            ],
          ],
          [
            'icon' => __('icons.groups'),
            'text' => __('resources.groups'),
            'active' => is_active_page(['groups']),
            'attrs' => [
              'href' => url('groups')
            ],
          ],
          [
            'icon' => __('icons.members'),
            'text' => __('resources.members'),
            'active' => is_active_page(['members']),
            'attrs' => [
              'href' => url('members')
            ],
          ],
          [
            'icon' => __('icons.programs'),
            'text' => __('resources.programs'),
            'active' => is_active_page(['programs']),
            'attrs' => [
              'href' => url('programs')
            ],
          ],
          [
            'icon' => __('icons.projects'),
            'text' => __('resources.projects'),
            'active' => is_active_page(['projects']),
            'attrs' => [
              'href' => url('projects')
            ],
          ],
          [
            'icon' => __('icons.products'),
            'text' => __('resources.products'),
            'active' => is_active_page(['products']),
            'attrs' => [
              'href' => url('products')
            ],
          ],
          [
            'icon' => __('icons.publications'),
            'text' => __('resources.publications'),
            'active' => is_active_page(['publications']),
            'attrs' => [
              'href' => url('publications')
            ],
          ],
        ]
      ]    
    ]) @enddrawerModal

    {{-- Conteúdo da página --}}
    <div class="top-app-bar--fixed-adjust mdc-top-app-bar--fixed-adjust">
      @yield('main')
    </div>

    {{-- Erros de validação --}}
    @if ($errors->any())
      @snackbar([
        'classes' => ['mdc-snackbar--align-start'],
        'attrs' => [
            'data-vint-auto-init' => 'VintSnackbar',
            'data-vint-snackbar-message' => $errors->first(),
            'data-vint-snackbar-action-text' => 'Ok',
        ]
      ]) @endsnackbar    
    @endif

    {{-- Snackbars --}}
    @if (session('snackbar'))
      @snackbar([
        'classes' => ['mdc-snackbar--align-start'],
        'attrs' => [
            'data-vint-auto-init' => 'VintSnackbar',
            'data-vint-snackbar-message' => session('snackbar'),
            'data-vint-snackbar-action-text' => 'Ok',
        ]
      ]) @endsnackbar    
    @endif    
    {{-- MDC --}}
    <script src="{{ asset('js/material-components-web.js') }}" defer></script>
    {{-- VINT --}}
    <script src="{{ asset('js/vint.js') }}" defer></script>
    {{-- Scripts injetados por páginas --}}
    @yield('scripts')
  </body>
</html>
