@extends('layouts.'.(
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('headlines.search')
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingSearch([
                'term' => $term,
                'tabActive' => 'all',
            ]) @endheadingSearch
        @endcell

        {{-- Verifica se existe ao menos um recurso com resultado --}}
        @if (!$firstWithResult)
            <h4 class="mdc-typography--headline4">
                {{ __('messages.search.not_found', [
                    'term' => $term
                ]) }}
            </h4>
        @else
            @foreach ($resources as $resource)
                @if (!$resource['items']->isEmpty())
                    @cell([
                        'when' => ['d' => (
                            !$isEvenResult &&
                            $resource['name'] === $firstWithResult ?
                                12 : 6
                        ), 't' => 8]
                    ])
                        @component("components.pagination.paginable-{$resource['name']}", [
                            'withoutSearch' => true,
                            'withoutActions' => true,
                            $resource['name'] => $resource['items']
                        ]) @endcomponent
                    @endcell                
                @endif
            @endforeach
        @endif
    @endgridWithInner
@endsection