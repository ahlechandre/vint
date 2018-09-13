<div class="paginator-empty">
    <h3 class="mdc-typography--headline5 typography--italic  typography--mono typography--faded">
        @if ($search ?? false)
            {{ __('messages.pagination.is_empty_search', [
                'query' => $search
            ]) }}
        @else
            {{ __('messages.pagination.is_empty') }}
        @endif    
    </h3>
</div>