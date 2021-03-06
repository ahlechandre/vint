@extends('layouts.default', [
    'title' => __('messages.errors.403.title')
])

@section('main')
    @gridInner
        @cell
            <h1 class="mdc-typography--headline1">
                403
            </h1>
            <h4 class="mdc-typography--headline4">
                {{ __('messages.errors.403.body_title') }}
            </h4>
        @endcell
    @endgridInner
@endsection