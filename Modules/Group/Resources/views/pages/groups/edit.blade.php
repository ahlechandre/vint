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
            @heading([
                'pretitle' => __('resources.groups'),
                'title' => __('messages.groups.forms.edit_title'),
            ]) @endheading
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
