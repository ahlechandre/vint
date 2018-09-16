@extends('layouts.master', [
    'title' => get_breadcrumb([
        $group->name,
        __('resources.projects'),
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
                'pretitle' => $group->name.' > '.__('resources.projects'),
                'title' => __('messages.projects.create'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("groups/{$group->id}/projects"),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-group-project'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.project',
                    'props' => [
                        'name' => old('name'),
                        'startOn' => old('start_on'),
                        'finishOn' => old('finish_on'),
                        'description' => old('description'),
                        'coordinatorUserId' => old('coordinator_user_id'),
                        'leaderUserId' => old('leader_user_id'),
                        'supporterUserId' => old('supporter_user_id'),
                        'programId' => old('program_id'),
                        'programs' => $programs,
                        'servantMembers' => $servantMembers,
                        'collaboratorMembers' => $collaboratorMembers,
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
