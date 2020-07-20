<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;
    protected $query;

    public function newQuery(): Builder
    {
        if (! $this->query) {
            $this->query = app($this->model)->newQuery();
        }

        return $this->query;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function create(array $attributes): Model
    {
        $model = $this->newQuery()->getModel()->newInstance();
        $model->fill($attributes);
        $model->saveOrFail();

        return $model;
    }

    public function createWithAssociations(array $attributes, array $associations = []): Model
    {
        $model = $this->newQuery()->getModel()->newInstance();
        $model->fill($attributes);

        foreach ($associations as $path => $association) {
            $model->$path()->associate($association);
        }

        $model->saveOrFail();

        return $model;
    }

    public function findBy(string $field, $value, array $attributes = ['*'])
    {
        if (! $this->query) {
            $this->newQuery();
        }

        return $this->query->where($field, $value)->select($attributes)->first();
    }

    public function update(Model $model, array $attributes): Model
    {
        $model->fill($attributes);

        if ($model->isDirty()) {
            $model->save();
        }

        return $model;
    }
}
