<?php

namespace Modules\System\Entities\Traits;

trait EloquentVint
{

    /**
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  null|string  $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterLike($query, $filter)
    {
        if (!$filter) {
            return $query;
        }

        array_reduce($this->filterable, function ($isNotFirst, $field) use ($query, $filter) {
            return $isNotFirst ?
                $query->orWhere($field, 'like', "%{$filter}%") :
                $query->where($field, 'like', "%{$filter}%");
        }, false);

        return $query;
    }

    /**
     *
     * @param  \Illuminate\Database\Query\Builder  $perPage
     * @param  null|int  $perPage
     * @return \Illuminate\Pagination\Paginator|\Illuminate\Support\Collection
     */
    public function scopeSimplePaginateOrGet($query, $perPage = null)
    {
        return $perPage ?
            $query->simplePaginate($perPage) :
            $query->get();
    }
}