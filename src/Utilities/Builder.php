<?php

namespace Debva\Utilities;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait Builder
{
    protected $whereClauseAttribute;

    protected $with;

    /**
     * @param string $whereClauseAttribute
     * 
     * @return $this
     */
    public function whereClauseAttribute(string $whereClauseAttribute)
    {
        $this->whereClauseAttribute = $whereClauseAttribute;
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
    public function getWhereClauseAttribute(): string
    {
        return $this->whereClauseAttribute ?? $this->attribute;
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
        if ($this->html) {
            return call_user_func($this->html, data_get($queryBuilder, $this->attribute), $queryBuilder);
        }

        if ($this->getType('date')) {
            return strftime($this->dateOutputFormat, strtotime($data));
        }

        if ($this->getWith()) {
            if ($queryBuilder->{$this->getWith()} instanceof \Collection) {
                $data = [];
                foreach ($queryBuilder->{$this->getWith()} as $relation) {
                    $data[] = $relation->{$this->attribute};
                }
                return $data;
            } else {
                return data_get($queryBuilder->{$this->getWith()}, $this->attribute);
            }
        }

        return data_get($queryBuilder, $this->attribute);
    }
}
