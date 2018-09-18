@extends('layouts.master', [
    'title' => get_breadcrumb([
        __('resources.projects'),
        $project->name,
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
                'pretitle' => __('resources.projects'),
                'title' => __('messages.projects.edit'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("projects/{$project->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-project'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.project',
                    'props' => [
                        'name' => $project->name,
                        'startOn' => $project->start_on
                            ->format('Y-m-d'),
                        'finishOn' => $project->finish_on ?
                            $project->finish_on
                                ->format('Y-m-d') :
                            null,
                        'description' => $project->description,
                        'programId' => $project->program_id,
                        'coordinatorUserId' => $project->coordinator_user_id,
                        'leaderUserId' => $project->leader_user_id,
                        'supporterUserId' => $project->supporter_user_id,
                        'programs' => $programs,
                        'servantMembers' => $servantMembers,
                        'collaboratorMembers' => $collaboratorMembers,
                    ],
                ]
            ]) @endform
        @endcell

    @endgridWithInner
@endsection
