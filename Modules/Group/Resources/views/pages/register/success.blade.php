@extends('layouts.default') 
@section('title', 'Registro com sucesso')

@section('main')
    {{-- Surface --}}
    @component('components.ui.top-app-bar-surface', [
      'modifiers' => [
        'top-app-bar-surface--expanded',
        'top-app-bar-surface--min-height',
      ]
    ]) @endcomponent
    
    {{-- Content --}}
    @layoutGridWithInner([
      'modifiers' => ['layout-grid--dense']
    ])
        @cell([
            'when' => ['default' => 12],
        ])
            <h1 class="mdc-typography--headline4">
                {{ __('messages.register.congrats', [
                    'name' => $member->user->name
                ]) }}
            </h1>
            <p class="mdc-typography--body1">
                {!! nl2br(__('messages.register.success')) !!}
            </p>
        @endcell

        @cell([
            'when' => ['default' => 12],
        ])
            @buttonLink([
                'text' => 'Ir para página inicial',
                'icon' => 'home',
                'attrs' => [
                    'href' => url('/')
                ]
            ]) @endbuttonLink
            
            @buttonLink([
                'text' => 'Fazer login',
                'modifiers' => ['mdc-button--raised'],
                'icon' => __('material_icons.login'),
                'attrs' => [
                    'href' => url('login')
                ]
            ]) @endbuttonLink 
        @endcell
    @endlayoutGridWithInner
  
@endsection