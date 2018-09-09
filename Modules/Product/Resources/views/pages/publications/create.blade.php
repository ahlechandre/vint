@extends('layouts.master', [
    'title' => __('resources.publications').' / '.__('actions.new') 
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
                'pretitle' => __('resources.publications'),
                'title' => __('messages.publications.forms.create_title'),
            ]) @endheading
        @endcell

        {{-- Formulário --}}
        @cell
            @form([
                'action' => url('publications'),
                'method' => 'post',
                'attrs' => [
                    'id' => 'form-publication',
                    'data-vint-auto-init' => 'VintFormPublication'
                ],
                'withCancel' => true,
                'withSubmit' => true,                
                'inputs' => [
                    'view' => 'product::inputs.publication',
                    'props' => [
                        'reference' => old('reference'),
                        'url' => old('url'),
                        'projects' => old('projects') ?
                            \Modules\Project\Entities\Project::forUser($user)
                                ->with('group')
                                ->find(old('projects'))
                        : null,
                        'members' => old('members') ?
                            \Modules\Member\Entities\Member::forUser($user)
                                ->with('user')
                                ->find(old('members'))
                        : null                        
                    ],
                ]
            ]) @endform        
        @endcell    
    @endgridWithInner
@endsection
