<?php

namespace Nour\Filter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class FilterScope implements Scope
{
    private $builder;
    private $table;

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $this->table = $model->getTable();
        $this->builder = $builder;
        $this->filter();
    }

    protected function hasFilter()
    {
        $request = \request()->all();
        if($this->table !== '') {
            foreach ($request as $key => $value) {
                if (!Schema::hasColumn((string)$this->table, $key)) {
                    unset($request[$key]);
                }
            }
        }
        return $request;

    }
    /**
     * Filter the query by a given username.
     *
     * @param  string $operator
     * @return Builder
     */
    protected function filter($operator = '=')
    {

        $filters = $this->hasFilter();
        if(!empty($filters)){
            foreach ($filters as $filter => $value){
                $this->builder->where($filter, $operator, $value);
            }

        }
        return $this->builder;
    }
}
