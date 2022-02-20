<?php

namespace Debva\LaravelDatatables\Utilities;

use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait Builder
{
    protected $whereClause;

    protected $whereHas;

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
     * @return string|null
     */
    public function getWhereClause()
    {
        return $this->whereClause;
    }

    /**
     * @param string $with
     * 
     * @return $this
     */
    public function whereHas(string $whereHas)
    {
        $this->whereHas = $whereHas;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getWhereHas()
    {
        return $this->whereHas;
    }

    /**
     * @param EloquentBuilder|QueryBuilder $queryBuilder
     * 
     * @return string|null
     */
    public function getData($queryBuilder, $attribute = null)
    {
        $value = data_get($queryBuilder, $attribute ?? $this->attribute);

        if (is_null($attribute)) {
            if ($this->html) {
                return call_user_func($this->html, $value, $queryBuilder);
            }

            if ($this->getType('date')) {
                if ($value) {
                    return strftime($this->dateFormat, strtotime($value));
                }
                return null;
            }
        }

        return $value;
    }
}
