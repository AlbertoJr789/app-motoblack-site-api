<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Get searchable fields array
     */
    abstract public function getFieldsSearchable(): array;

    /**
     * Configure the Model
     */
    abstract public function model(): string;

    /**
     * Make Model instance
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = app($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     */
    public function paginate(int $perPage,array $search = [],array $columns = ['*'],array $eagerLoads = [],bool $simple = false,$beforePaginating = null): LengthAwarePaginator|Paginator
    {
        $query = $this->allQuery(search: $search,eagerLoads: $eagerLoads);
        if($beforePaginating){
            $beforePaginating($query);
        }
        
        return $simple ? $query->simplePaginate($perPage,$columns) : $query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     */
    public function allQuery(array $search = [], int $skip = null, int $limit = null, array $eagerLoads = []): Builder
    {
        $query = $this->model->newQuery();

        if (count($search)) {
            foreach($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->where($key, $value);
                }
            }
        }

        if(count($eagerLoads)){
            $query->with($eagerLoads);
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria
     */
    public function all(array $search = [], int $skip = null, int $limit = null, array $columns = ['*']): Collection
    {
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record
     */
    public function create(array $input): Model
    {
        $input['creator_id'] = Auth::id();
        $model = $this->model->newInstance($input);

        $model->save();

        return $model;
    }

    /**
     * Find model record for given id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function find(int $id, array $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update(array $input, $id)
    {
        $input['editor_id'] = Auth::id();
        $input['active'] = isset($input['active']) ? 1 : 0;

        $query = $this->model->newQuery();

        $model = is_int($id) ? $query->findOrFail($id) : $id; 

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function delete(int $id)
    {
        $query = $this->model->newQuery();

        $model = $query->findOrFail($id);

        return $model->delete();
    }

    
    /**
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function deleteMultiple(array $ids)
    {
        $query = $this->model->newQuery();

        $model = $query->whereIn($this->model->getKeyName(),$ids);

        return $model->update([
            'deleter_id' => Auth::id(),
            'deleted_at' => now()
        ]);
    }

      /**
     * @throws \Exception
     *
     * @return bool|mixed|null
     */
    public function restoreMultiple(array $ids)
    {
        $query = $this->model->newQuery();

        $model = $query->onlyTrashed()->whereIn($this->model->getKeyName(),$ids);

        return $model->update([
            'deleter_id' => null,
            'deleted_at' => null
        ]);
    }

}
