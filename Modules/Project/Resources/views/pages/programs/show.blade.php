@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.programs').' / '.$program->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingProgram([
                'program' => $program,
                'tabActive' => 'about',
            ]) @endheadingProgram
        @endcell

        @cell
            {{-- Informações --}}
            @foreach($program->getAttributes() as $attr => $value)
                <p>
                    {{ $attr }} => {{ $value }}
                </p>
            @endforeach

            {{-- Editar --}}
            @can('update', $program)
                @fabFixed([
                    'fab' => [
                        'isLink' => true,
                        'icon' => __('icons.edit'),
                        'classes' => ['mdc-fab--extended'],
                        'label' => __('actions.edit'),
                        'attrs' => [
                            'href' => url("programs/{$program->id}/edit"),
                            'title' => __('messages.programs.forms.edit_title'),
                        ],
                    ]
                ]) @endfabFixed
            @endcan
        @endcell
    @endgridWithInner
@endsection
