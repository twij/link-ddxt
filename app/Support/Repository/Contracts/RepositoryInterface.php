<?php

namespace App\Support\Repository\Contracts;

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
}
