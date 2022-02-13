<?php

namespace Debva\LaravelDatatables\Utilities;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait Builder
{
    protected $whereClause;

    protected $with;

    /**
     * @param string $whereClause
     * 
     * @return $this
     */
    public function whereClause(string $whereClause)
    {
        $this->whereClause = $whereClause;
        return $this;
    }

    /**
     * @param string $with
     * 
     * @return $this
     */
    public function with(string $with)
    {
        $this->with = $with;
        return $this;
    }

    /**
     * @return string
     */
    public function getWhereClause(): string
    {
        return $this->whereClause ?? $this->attribute;
    }

    /**
     * @return string|null
     */
    public function getWith()
    {
        return $this->with;
    }

    /**
     * @param EloquentBuilder|QueryBuilder $queryBuilder
     * 
     * @return string|null
     */
    public function getData($queryBuilder)
    {
        $value = data_get(($this->getWith() ? $queryBuilder->{$this->getWith()} : $queryBuilder), $this->attribute);

        if ($this->html) {
            return call_user_func($this->html, $value, $queryBuilder);
        }

        if ($this->getType('date')) {
            return strftime($this->dateOutputFormat, strtotime($value));
        }

        if ($this->getWith()) {
            if ($queryBuilder->{$this->getWith()} instanceof \Collection) {
                $data = [];
                foreach ($queryBuilder->{$this->getWith()} as $relation) {
                    $data[] = $relation->{$this->attribute};
                }
                return $data;
            }
            return $value;
        }

        return $value;
    }
}
