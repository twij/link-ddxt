<?php

namespace App\Support\Criteria;

use Illuminate\Database\Eloquent\Model;
use App\Support\Criteria\Contracts\CriteriaInterface;

class Criteria implements CriteriaInterface
{
    /**
     * Apply the criteria to a model
     *
     * @param Model $model Model
     *
     * @return Builder Query builder
     */
    public function apply(Model $model): \Illuminate\Database\Eloquent\Builder
    {
        return $model->get();
    }

    /**
     * Check if current model is supported by criteria
     *
     * @param Model $model Model
     *
     * @return bool Status
     */
    public function supported(Model $model): bool
    {
        if (! isset($this->supported)) {
            return true;
        }

        if (in_array($model->make()->getTable(), $this->supported)) {
            return true;
        }

        return false;
    }
}
