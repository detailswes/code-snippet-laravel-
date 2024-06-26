<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\QueryFilters;

trait Filterable
{
    public function scopeFilter($query, QueryFilters $filters)
    {
        return $filters->apply($query);
    }
}
