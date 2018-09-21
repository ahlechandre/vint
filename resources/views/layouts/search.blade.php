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
        'icon' => __('icons.back'),
        'attrs' => [
          'href' => url('/'),
          'title' => __('actions.back')
        ]
      ],
      'title' => [
        'attrs' => [
          'href' => url('/')
        ],
        'text' => 'VINT',
      ]
    ]) @endtopAppBarHome

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
    {{-- Footer --}}
    @footerDefault @endfooterDefault
    {{-- MDC --}}
    <script src="{{ asset('js/material-components-web.js') }}" defer></script>
    {{-- VINT --}}
    <script src="{{ asset('js/vint.js') }}" defer></script>
    {{-- Scripts injetados por páginas --}}
    @yield('scripts')
  </body>
</html>
