@extends('layouts.default') 
@section('title', 'Membro')

@section('main')
<h1>membro</h1>

<p>
    {{ $memberType->name }}
</p>
@endsection