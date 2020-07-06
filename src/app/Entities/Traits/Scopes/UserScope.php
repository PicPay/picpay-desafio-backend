<?php

namespace App\Traits\Scopes;

trait UserScope {
    /**
     * Scope a query to only users by filters.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $filter)
    {
        (isset($filter['name'])) ? $query->where('name', $filter['name']) : '';
        (isset($filter['document'])) ? $query->where('document', $filter['document']) : '';
        (isset($filter['email'])) ? $query->where('email', $filter['email']) : '';
        (isset($filter['type'])) ? $query->where('type', $filter['type']) : '';

        return $query->latest()->paginate();
    }
}