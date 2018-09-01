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
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
    {{-- MDC + App --}}
    <link rel="stylesheet" href="{{ asset('css/vint.css') }}">
  </head>
  <body class="mdc-typography mdc-theme theme typography">
    {{-- Top App Bar --}}
    @topAppBarHome([
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
        'id' => 'drawer-modal-default'
      ],
      'header' => [
        'title' => 'VINT',
        'subtitle' => 'Computação Visual e Interativa',
      ],
      'list' => [
        'isNavigation' => true,
        'items' => [
          [
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
        ]
      ]

    ]) @enddrawerModal

    {{-- Conteúdo da página --}}
    <div class="top-app-bar--fixed-adjust mdc-top-app-bar--fixed-adjust">
      @yield('main')
    </div>
    
    {{-- MDC --}}
    <script src="{{ asset('js/material-components-web.js') }}" defer></script>
    {{-- VINT --}}
    <script src="{{ asset('js/vint.js') }}" defer></script>
    {{-- Scripts injetados por páginas --}}
    @yield('scripts')
  </body>
</html>
