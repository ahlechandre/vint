<div class="heading">

    <div class="heading__primary">
        <div class="heading__title">
            @if ($pretitle ?? false)
                <p class="heading__pretitle-text">
                    {{ $pretitle }}
                </p>
            @endif

            <h1 class="heading__title-text mdc-typography--headline3">{{ $title }}</h1>
        </div>

        @if ($action ?? false)
            <div class="heading__action">
                @if ($action['button'] ?? false)
                    @button($action['button']) @endbutton
                @elseif ($action['iconButton'] ?? false) 
                    @iconButton($action['iconButton']) @endiconButton
                @elseif ($action['dialogContainer'] ?? false) 
                    @dialogContainer($action['dialogContainer']) @enddialogContainer
                @endif
            </div>
        @endif    
    </div>    
    
    @if ($content ?? false)
        <div class="heading__content">
            <p class="heading__content-text mdc-typography--headline6">{{ $content }}</p>
        </div>
    @endif

    @if ($tabBar ?? false)
        <div class="heading__tab-bar">
            @tabBar($tabBar) @endtabBar        
        </div>
    @endif
</div>