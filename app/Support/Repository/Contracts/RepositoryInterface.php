<?php

namespace App\Support\Repository\Contracts;

use App\Support\Criteria\Criteria;
use App\Support\Repository\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /**
     * Return all entries
     *
     * @param array $columns Columns to select
     *
     * @return null|Collection Collection of entries
     */
    public function all($columns = array('*')): ?\Illuminate\Support\Collection;

    /**
     * Paginate entries
     * @param int       $perPage  Items per page
     * @param array     $columns  Columns to select
     * @param int|null  $page     Page number to return
     * 
     * @return null|LengthAwarePaginator Paginated results
     */
    public function paginate(
        int $perPage = 1,
        array $columns = ['*'],
        int $page = null
    ): ?\Illuminate\Pagination\LengthAwarePaginator;

    /**
     * Create new entry
     *
     * @param array $data Model data
     *
     * @return Model New model 
     */
    public function create(array $data): Model;

    /**
     * Update an entry
     *
     * @param array  $data  Updated attributes
     * @param int    $id    Entry identifier
     * 
     * @return Model Updated model 
     */
    public function update(array $data, int $id): Model;

    /**
     * Delete an entry
     *
     * @param int $id Id to delete
     *
     * @return null|bool Status 
     */
    public function delete(int $id): ?bool;

    /**
     * Find an entry
     *
     * @param int    $id       Id to find
     * @param array  $columns  Columns to select
     *
     * @return null|Model Requested model
     */
    public function find(int $id, array $columns = ['*']): ?Model;

    /**
     * Find an entry by field
     *
     * @param string  $attribute  Field to search
     * @param mixed   $value      Value to search
     * @param array   $columns    Columns to select
     *
     * @return Model
     */
    public function findBy(string $attribute, $value, array $columns = ['*']): Model;

    /**
     * Set eager loaded relations
     *
     * @param array $relations Relationship names to eager load
     *
     * @return Repository Self
     */
    public function with(array $relations = []): \App\Support\Repository\Repository;

        /**
     * Reset the criteria scope
     *
     * @return Warrantywise\Support\Repository\Repository $this Self
     */
    public function resetScope(): \App\Support\Repository\Repository;

    /**
     * Skip the criteria
     *
     * @param bool $status Skip status
     *
     * @return \Warrantywise\Support\Repository\Repository $this Self
     */
    public function skipCriteria(bool $status = true): \App\Support\Repository\Repository;

    /**
     * Return the applied criteria
     *
     * @return \Illuminate\Support\Collection Criteria collection
     */
    public function getCriteria(): \Illuminate\Support\Collection;

    /**
     * Get entries by criteria
     *
     * @param Criteria $criteria Criteria to apply
     */
    public function getByCriteria(Criteria $criteria);

    /**
     * Apply a criteria to the collection
     *
     * @param Criteria $criteria Criteria to apply
     *
     * @return \Warrantywise\Support\Repository\Repository $this Self
     */
    public function pushCriteria(Criteria $criteria): \App\Support\Repository\Repository;

    /**
     * Apply the criteria to the repository
     *
     * @return mixed $this Models
     */
    public function applyCriteria();
}
