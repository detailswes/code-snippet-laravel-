<?php
namespace App\Filters;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserFilters extends QueryFilters
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        parent::__construct($request);
    }

    public function firstName($term)
    {
        return $this->builder->where('first_name', 'LIKE', "%$term%");
    }

    public function lastName($term)
    {
        return $this->builder->where('last_name', 'LIKE', "%$term%");
    }

    public function email($term)
    {
        return $this->builder->where('email', 'LIKE', "%$term%");
    }

    public function roleId($term)
    {
         return $this->builder->where('role_id', $term);
    }

    public function filterByDate($dateFilters = [])
    {
        if (!empty($dateFilters['end_date']) && !empty($dateFilters['start_date'])) {
            $this->builder->whereBetween('created_at', [
              Carbon::parse($dateFilters['start_date'])->format('Y-m-d'),
              Carbon::parse($dateFilters['end_date'])->format('Y-m-d')
          ]);
        } else if (!empty($dateFilters['start_date'])) {
            $this->builder->whereDate('created_at', '>=', Carbon::parse($dateFilters['start_date'])->format('Y-m-d'));
        } else if (!empty($dateFilters['end_date'])) {
            $this->builder->whereDate('users.created_at', '<=',Carbon::parse($dateFilters['end_date'])->format('Y-m-d'));
        }

        return $this->builder;
    }
}
