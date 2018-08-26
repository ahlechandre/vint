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
        'classes' => ['drawer-activation'],
        'attrs' => [
          'href' => '#',
          'data-drawer-activation' => 'drawer-temporary-1',
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
        'id' => 'drawer-temporary-1'
      ],
      'header' => [
        'title' => 'Alexandre Thebaldi',
        'subtitle' => 'ahlechandre@gmail.com',
      ],
      'listGroup' => [
        'groups' => [
          [
            'list' => [
              'isNavigation' => true,
              'items' => [
                [
                  'icon' => 'dashboard',
                  'text' => 'Dashboard',
                  'attrs' => [
                    'href' => url('dashboard')
                  ],
                ],
                [
                  'icon' => 'person',
                  'text' => 'Usuários',
                  'attrs' => [
                    'href' => url('users')
                  ],
                ]          
              ]
            ]
          ],
          [
            'subheader' => 'Sistema',
            'list' => [
              'isNavigation' => true,
              'items' => [
                [
                  'icon' => 'dashboard',
                  'text' => 'Dashboard',
                  'attrs' => [
                    'href' => url('dashboard')
                  ],
                  'classes' => ['mdc-list-item--activated']
                ],
                [
                  'icon' => 'person',
                  'text' => 'Usuários',
                  'attrs' => [
                    'href' => url('users')
                  ],
                ]          
              ]
            ]          

          ]          
        ]
      ]
    ]) @enddrawerTemporary

    {{-- Conteúdo da página --}}
    <div class="mdc-top-app-bar--fixed-adjust">
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
