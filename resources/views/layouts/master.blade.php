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
          'data-drawer-activation' => 'drawer-modal-master',
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
        'id' => 'drawer-modal-master',
      ],
      'header' => [
        'title' => $user->name,
        'subtitle' => $user->email,        
      ],
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
            'active' => is_active_page(['users']),
            'attrs' => [
              'href' => url('users')
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
          [
            'dividerBefore' => true,
            'icon' => __('icons.settings'),
            'text' => __('headlines.settings'),
            'active' => is_active_page('settings'),
            'attrs' => [
              'href' => url('settings')
            ],
          ],
          [
            'icon' => __('icons.profile'),
            'text' => __('headlines.my_profile'),
            'active' => is_active_page("members/{$user->id}"),
            'attrs' => [
              'href' => url("members/{$user->id}")
            ],
          ],
          [
            'dividerBefore' => true,
            'icon' => __('icons.logout'),
            'text' => __('actions.logout'),
            'attrs' => [
              'href' => url('logout')
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
