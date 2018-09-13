<div class="paginator-empty">
    <h3 class="mdc-typography--headline4">
        @if ($search ?? false)
            {{ __('messages.pagination.is_empty_search', [
                'query' => $search
            ]) }}
        @else
            {{ __('messages.pagination.is_empty') }}
        @endif    
    </h3>
</div>