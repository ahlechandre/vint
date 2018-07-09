@extends('layouts.default')
@section('title', 'Erro 403')

@section('main')
    <style>
        body {
            text-align: center;
        }
    </style>

    @component('material.layout-grid-with-inner')
            
        @component('material.cell', [
        'when' => ['default' => 12]
        ])
            <h1 class="mdc-typography--headline4">
                Erro 403
            </h1>
            <h1 class="mdc-typography--headline5">
                Permissão negada
            </h1>
        @endcomponent

        @component('material.cell', [
        'when' => ['default' => 12]
        ])
            <a href="#" id="button-back" class="mdc-button">Voltar</a>
        @endcomponent        
    @endcomponent

@endsection

@section('scripts')
<script>
    (function () {
        var page = function () {
            var buttonBack = document.querySelector('#button-back');
            buttonBack.addEventListener('click', function () {
                event.preventDefault()
                history.back()
            });
        };

        window.addEventListener('load', page);
    })()
</script>
@endsection