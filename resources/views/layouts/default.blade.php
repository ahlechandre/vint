<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} @if (View::hasSection('title')) / @yield('title') @endif
    </title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body class="mdc-typography">
    @yield('main')

    {{-- Snackbars --}}
    @if (session('snackbar')) 
      @component('material.snackbar', [
        'message' => session('snackbar'),
        'actionText' => 'OK',
      ]) @endcomponent
    @endif
  
    <script src="{{ asset('js/material-components-web.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
  </body>
</html>
