<?php

namespace App\Support\Criteria\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface CriteriaInterface
{
    /**
     * Apply the criteria to a model
     *
     * @param Model $model Model
     *
     * @return Builder Query builder
     */
    public function apply(Model $model): \Illuminate\Database\Eloquent\Builder;

    /**
     * Check if current model is supported by criteria
     *
     * @param Model $model Model
     *
     * @return bool Status
     */
    public function supported(Model $model): bool;
}
