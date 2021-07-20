<?php

namespace App\Support\Repository;

use App\Support\Criteria\Criteriable;
use App\Support\Repository\Contracts\RepositoryInterface;
use App\Support\Repository\Exceptions\RepositoryException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;

abstract class Repository implements RepositoryInterface
{
    use Criteriable;

    /**
     * Application
     */
    private Container $app;

    /**
     * Model
     */
    protected $model;

    /**
     * Relationships to eager load
     */
    protected array $with = [];

    /**
     * @param Container  $container  Application
     * @param Collection $collection Collection
     *
     * @throws RepositoryException Exception
     */
    public function __construct(Container $app, Collection $collection)
    {
        $this->app = $app;
        $this->criteria = $collection;
        $this->resetScope();
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * Get all entries
     *
     * @param array $columns Filter columns
     *
     * @return \Illuminate\Support\Collection|null Models
     */
    public function all($columns = array('*')): ?\Illuminate\Support\Collection
    {
        $this->applyCriteria();
        return $this->model->with($this->with)->get($columns);
    }

    /**
     * Paginate the results
     *
     * @param int   $perPage Amount per page
     * @param array $columns Filter columns
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|null Paginator
     */
    public function paginate(
        int $perPage = 1,
        array $columns = ['*'],
        int $page = null
    ): ?\Illuminate\Pagination\LengthAwarePaginator {
        $this->applyCriteria();
        return $this->model->with($this->with)->paginate($perPage, $columns, 'page', $page);
    }

    /**
     * Create an entry
     *
     * @param array $data Model data
     *
     * @return mixed Created model
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Update a model
     *
     * @param array   $data       Data
     * @param int     $id         Id
     * @param string  $attribute  Attribute
     *
     * @return Model Updated model
     */
    public function update(array $data, int $id): Model
    {
        if ($entry = $this->model->where('id', '=', $id)->first()) {
            if ($entry->update($data)) {
                return $entry;
            }
        }
        return null;
    }

    /**
     * Delete an entry
     *
     * @param int $id Id to delete
     *
     * @return mixed
     */
    public function delete(int $id): ?bool
    {
        return $this->model->delete($id);
    }

    /**
     * Find an entry
     *
     * @param int   $id      ID
     * @param array $columns Column
     *
     * @return mixed Result
     */
    public function find(int $id, array $columns = ['*']): Model
    {
        $this->applyCriteria();
        return $this->model->with($this->with)->find($id, $columns);
    }

    /**
     * Find a model by a field
     *
     * @param mixed $attribute Attribute
     * @param mixed $value     Value
     * @param array $columns   Columns
     *
     * @return mixed Result
     */
    public function findBy(string $attribute, $value, array $columns = ['*']): Model
    {
        $this->applyCriteria();
        return $this->model->with($this->with)->where(
            $attribute,
            '=',
            $value
        )->first($columns);
    }

    /**
     * Eager load relationships
     *
     * @param array $relations Relationships to load
     *
     * @return \Warrantywise\Support\Repository\Repository Repository instance
     */
    public function with(array $relations = []): \App\Support\Repository\Repository
    {
        $this->with = $relations;
        return $this;
    }

    /**
     * Make the model
     *
     * @throws RepositoryException
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new RepositoryException(
                "Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model"
            );
        }

        return $this->model = $model;
    }

    /**
     * Get the model instance
     *
     * @return mixed Model
     *
     * @throws BindingResolutionException
     */
    public function getModel()
    {
        return $this->app->make($this->model());
    }
}
