@extends('layouts.master', [
    'title' => get_breadcrumb([
        __('resources.groups'),
        __('actions.new')
    ]) 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @heading([
                'pretitle' => __('resources.groups'),
                'title' => __('messages.groups.create'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url('groups'),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-group'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.group',
                    'props' => [
                        'name' => old('name'),
                        'description' => old('description'),
                        'isActive' => true,
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
