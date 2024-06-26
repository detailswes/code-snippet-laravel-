<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait NextAndPrevious
{
    public function scopeNext(Builder $query)
    {
        return optional($query->where('id', '>', $this->id)->isNotSuperAdmin()->orderBy('id', 'asc')->first());
    }

    public function scopePrevious(Builder $query)
    {
        return optional($query->where('id', '<', $this->id)->isNotSuperAdmin()->orderBy('id', 'desc')->first());
    }

    public function scopeNextAndPrevious(Builder $query)
    {
        $this['next_id'] =  $this->next()->id;
        $this['previous_id'] =  $this->previous()->id;
        return $this;
    }
}
