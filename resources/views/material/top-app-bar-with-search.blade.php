@if ($breadcrumbs ?? false)
<header class="top-app-bar top-app-bar--breadcrumbs mdc-top-app-bar mdc-top-app-bar--fixed">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section">
            {{-- Menu --}}
            <a class="material-icons mdc-top-app-bar__navigation-icon"
                {{ setAttributes($menu['attrs']) }}>{{ $menu['icon'] }}
            </a>

            <ol class="breadcrumbs__list">
                @foreach($breadcrumbs as $breadcrumb)
                    <li class="breadcrumbs__crumb">
                        <a class="breadcrumbs__crumb-link" {{ setAttributes($breadcrumb['attrs']) }}>
                            {{ $breadcrumb['text'] }}
                        </a>                            
                    </li>
                @endforeach
            </ol>            
        </section>
    </div>
</header>
@endif

<header class="top-app-bar top-app-bar--with-search mdc-top-app-bar{{ isset($tabs) ? ' top-app-bar--with-tabs' : '' }}{{ setModifiers($modifiers ?? null) }}">
    {{-- Search Row --}}
    <div class="mdc-top-app-bar__row top-app-bar__row top-app-bar__row--search">
        {{-- Start Section --}}
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <form action="{{ url('/users') }}" method="get">
                <div class="text-field text-field--top-app-bar-search mdc-text-field mdc-text-field--with-trailing-icon mdc-text-field--fullwidth">
                    <input type="text" 
                        name="q" 
                        autocomplete="off" 
                        placeholder="Buscar" 
                        class="mdc-text-field__input text-field__input top-app-bar__input-search">      
                </div>
            </form>
        </section>
        {{-- End Section --}}
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            {{-- Close Button --}}
            <a href="#" 
                class="material-icons mdc-top-app-bar__action-item top-app-bar__action-close-search"
                aria-label="Fechar" 
                alt="Fechar">close</a>
        </section>
    </div>
    
    {{-- Default Row --}}
    <div class="mdc-top-app-bar__row top-app-bar__row">    
        {{-- Start Section --}}
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            {{-- Menu --}}
            <a class="material-icons mdc-top-app-bar__navigation-icon"
                {{ setAttributes($menu['attrs']) }}>{{ $menu['icon'] }}
            </a>
            {{-- Title --}}
            <span class="mdc-top-app-bar__title">
                {{ $title }}
            </span>
        </section>
        {{-- End Section --}}
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            {{-- Search Open Button --}}
            <a href="#" 
                class="material-icons mdc-top-app-bar__action-item top-app-bar__action-open-search"
                aria-label="Search"
                alt="Search">search</a>

            @foreach($actions as $action)
                <a class="material-icons mdc-top-app-bar__action-item"
                    {{ setAttributes($action['attrs']) }}>{{ $action['icon'] }}</a>
            @endforeach
        </section>
    </div>

    @if ($tabs ?? false)
        <div class="mdc-top-app-bar__row top-app-bar__row top-app-bar__row--tabs">
            <section class="top-app-bar__section mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                @component('material.tabs-scroller', $tabs) @endcomponent            
            </section>
        </div>
    @endif
</header>