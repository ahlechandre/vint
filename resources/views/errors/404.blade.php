@extends('layouts.default', [
    'title' => __('messages.errors.404.title')
])

@section('main')
    @gridInner
        @cell
            <h1 class="mdc-typography--headline1">
                404
            </h1>
            <h4 class="mdc-typography--headline4">
                {{ __('messages.errors.404.body_title') }}
            </h4>
        @endcell
    @endgridInner
@endsection