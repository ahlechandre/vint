@extends('layouts.master', [
    'title' => get_breadcrumb([
        $group->name,
        __('resources.programs'),
        __('actions.new'),
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
                'pretitle' => $group->name.' > '.__('resources.programs'),
                'title' => __('messages.programs.create'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("groups/{$group->id}/programs"),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-group-program'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.program',
                    'props' => [
                        'name' => old('name'),
                        'startOn' => old('start_on'),
                        'finishOn' => old('finish_on'),
                        'description' => old('description'),
                        'coordinatorUserId' => old('coordinator_user_id'),
                        'servantMembers' => $servantMembers,
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
