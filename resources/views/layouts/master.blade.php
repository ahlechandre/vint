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
          'data-drawer-activation' => 'drawer-temporary-master',
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

    @drawerTemporary([
      'attrs' => [
        'id' => 'drawer-temporary-master'
      ],
      'header' => [
        'title' => $user->name,
        'subtitle' => $user->email,
      ],
      'listGroup' => [
        'groups' => [
          [
            'list' => [
              'isNavigation' => true,
              'items' => [
                [
                  'icon' => __('icons.dashboard'),
                  'text' => __('headlines.dashboard'),
                  'active' => is_active_page('dashboard'),
                  'attrs' => [
                    'href' => url('dashboard')
                  ],
                ],
                [
                  'ignore' => !$user->isAdmin(),
                  'icon' => __('icons.users'),
                  'text' => __('resources.users'),
                  'active' => is_active_page('users'),
                  'attrs' => [
                    'href' => url('users')
                  ],
                ], 
                [
                  'icon' => __('icons.group'),
                  'text' => __('headlines.my_groups'),
                  'active' => is_active_page('me/groups'),
                  'attrs' => [
                    'href' => url('me/groups')
                  ],
                ],                               
              ]
            ]
          ],
        ]
      ]
    ]) @enddrawerTemporary

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
