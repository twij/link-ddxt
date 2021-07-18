<?php

namespace App\Domain\URLRedirect\Criteria;

use App\Support\Criteria\Criteria;
use Carbon\Carbon;

class ExpiredURLRedirectsCriteria extends Criteria
{
    /**
     * Apply the criteria
     *
     * @param mixed $model Model
     *
     * @return \Illuminate\Database\Eloquent\Builder Filtered criteria
     */
    public function apply($model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->whereDate('delete_at', '<=', Carbon::now());
    }
}
