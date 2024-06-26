<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class QueryFilters
{
    protected $request;
    protected $builder;

    protected $excludeFields = [
      'start_date',
      'end_date'
    ];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;
        $filters = $this->filters()['filters'] ?? [];

        if (
            isset($filters['start_date']) ||
            isset($filters['end_date'])
        ) {
            $this->filterByDate($filters);
            $filters = Arr::except($filters, ['start_date', 'end_date']);
        }

        foreach ($filters as $name => $value) {
          $camelCaseName = Str::camel($name);
  
          if (!method_exists($this, $camelCaseName)) {
              continue;
          }
          if (strlen($value)) {
            $this->$camelCaseName($value);
          }
        }
        return $this->builder;
    }

    public function filters()
    {
        return $this->request->all();
    }
}
