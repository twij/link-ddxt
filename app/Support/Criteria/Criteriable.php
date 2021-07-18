<?php

namespace App\Support\Criteria;

use Illuminate\Support\Collection;

trait Criteriable
{
    /**
     * Criteria
     */
    protected Collection $criteria;

    /**
     * Skip criteria
     */
    protected bool $skipCriteria = false;

    /**
     * Reset the criteria scope
     *
     * @return Warrantywise\Support\Repository\Repository $this Self
     */
    public function resetScope(): \App\Support\Repository\Repository
    {
        $this->criteria = new Collection();
        $this->skipCriteria(false);
        return $this;
    }

    /**
     * Skip the criteria
     *
     * @param bool $status Skip status
     *
     * @return \Warrantywise\Support\Repository\Repository $this Self
     */
    public function skipCriteria(bool $status = true): \App\Support\Repository\Repository
    {
        $this->skipCriteria = $status;
        return $this;
    }

    /**
     * Return the applied criteria
     *
     * @return \Illuminate\Support\Collection Criteria collection
     */
    public function getCriteria(): \Illuminate\Support\Collection
    {
        return $this->criteria;
    }

    /**
     * Get entries by criteria
     *
     * @param Criteria $criteria Criteria to apply
     */
    public function getByCriteria(Criteria $criteria)
    {
        $this->model = $criteria->apply($this->model, $this);
        return $this->model->with($this->with);
    }

    /**
     * Apply a criteria to the collection
     *
     * @param Criteria $criteria Criteria to apply
     *
     * @return \Warrantywise\Support\Repository\Repository $this Self
     */
    public function pushCriteria(Criteria $criteria): \App\Support\Repository\Repository
    {
        $this->criteria->push($criteria);
        return $this;
    }

    /**
     * Apply the criteria to the repository
     *
     * @return mixed $this Models
     */
    public function applyCriteria()
    {
        if ($this->skipCriteria === true) {
            return $this;
        }

        foreach ($this->getCriteria() as $criteria) {
            if ($criteria instanceof Criteria) {
                if (!isset($criteria->skip) || $criteria->skip == false) {
                    $this->model = $criteria->apply($this->model, $this);
                }
            }
        }

        return $this;
    }
}
