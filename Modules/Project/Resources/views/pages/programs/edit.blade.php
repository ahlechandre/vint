@extends('layouts.master', [
    'title' => get_breadcrumb([
        __('resources.programs'),
        $program->name,
        __('actions.edit')        
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
                'pretitle' => __('resources.programs'),
                'title' => __('messages.programs.edit'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("programs/{$program->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-program'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.program',
                    'props' => [
                        'name' => $program->name,
                        'startOn' => $program->start_on
                            ->format('Y-m-d'),
                        'finishOn' => $program->finish_on ?
                            $program->finish_on
                                ->format('Y-m-d') :
                            null,
                        'description' => $program->description,
                        'coordinatorUserId' => $program->coordinator_user_id,
                        'servantMembers' => $servantMembers,
                    ],
                ]
            ]) @endform
        @endcell

    @endgridWithInner
@endsection
