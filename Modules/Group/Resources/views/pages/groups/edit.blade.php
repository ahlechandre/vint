@extends('layouts.master', [
    'title' => __('resources.groups').' / '.$group->name.' / '.__('actions.edit') 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingGroupEdit([
                'group' => $group,
                'tabActive' => 'general',
            ]) @endheadingGroupEdit
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url("groups/{$group->id}"),
                'method' => 'put',
                'attrs' => [
                    'id' => 'form-group'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'group::inputs.group',
                    'props' => [
                        'name' => $group->name,
                        'description' => $group->description,
                        'isActive' => $group->is_active ? true : false,
                    ],
                ]
            ]) @endform
        @endcell

    @endgridWithInner
@endsection
