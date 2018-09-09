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

        // Campos filtráveis.
        array_reduce($this->filterable, function ($isNotFirst, $field) use ($query, $filter) {
            return $isNotFirst ?
                $query->orWhere($field, 'like', "%{$filter}%") :
                $query->where($field, 'like', "%{$filter}%");
        }, false);

        // Relações filtráveis.
        if (isset($this->filterableRelations)) {
            $selectRelation = function ($query) use ($filter) {
                return $query->filterLike($filter);
            };

            array_reduce($this->filterableRelations, function ($initial, $relation) use ($query, $selectRelation) {
                $query->orWhereHas($relation, $selectRelation);
            });
        }
        
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