<?php

namespace App\Domain\URLRedirect\Criteria;

use App\Support\Criteria\Criteria;

class ArchivableURLRedirectsCriteria extends Criteria
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
        return $model->where('user_id', null)->where('deleted_at', null);
    }
}
