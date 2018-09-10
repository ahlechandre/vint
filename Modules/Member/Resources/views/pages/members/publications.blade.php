@extends('layouts.'. (
    auth()->check() ? 'master' : 'default'
), [
    'title' => __('resources.members').' / '.$member->user->name 
])

@section('main')
    @gridWithInner([
        'grid' => [
            'classes' => ['layout-grid--dense']
        ]
    ])
        {{-- Heading --}}
        @cell
            @headingMember([
                'member' => $member,
                'tabActive' => 'publications',
            ]) @endheadingMember
        @endcell

        @cell
            @paginable([
                'paginator' => $publications,
                'list' => [
                    'twoLine' => true,
                    'nonInteractive' => true,
                    'items' => $publications->map(function ($publication) use ($user) {
                        return [
                            'icon' => __('icons.publication'),
                            'text' => [
                                'link' => url("publications/{$publication->id}"),
                                'primary' => $publication->reference,
                                'secondary' => $publication->created_at
                                    ->diffForHumans(),
                            ],
                            'meta' => [
                                'iconButton' => [
                                    'isLink' => true,
                                    'icon' => __('icons.show'),
                                    'attrs' => [
                                        'href' => url("publications/{$publication->id}")
                                    ]
                                ]
                            ],
                        ];
                    }),                    
                ]
            ]) @endpaginable
        @endcell
    @endgridWithInner
@endsection
