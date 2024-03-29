<?php

namespace Debva\LaravelDatatables\Actions;

use Debva\LaravelDatatables\Http\Request;

class Filtering
{
    public static function create($queryBuilder, $columns)
    {
        $columnFilters = Request::getColumnFilters();

        foreach ($columns as $column) {
            if ($column->getType('group')) {
                foreach ($column->getChildren() as $child) {
                    $queryBuilder = self::filtering($queryBuilder, $child, $columnFilters);
                }
            } else {
                $queryBuilder = self::filtering($queryBuilder, $column, $columnFilters);
            }
        }

        return $queryBuilder;
    }


    protected static function filtering($queryBuilder, $column, $columnFilters)
    {
        if ($column->isFilterable() and array_key_exists($column->getAttribute(), $columnFilters)) {

            $filterValues = $columnFilters[$column->getAttribute()];

            if (!is_array($filterValues)) {
                $filterValues = [$filterValues];
            }

            if (!is_null($column->getWhereHas()) and !is_null($column->getWhereClause())) {
                $queryBuilder = $queryBuilder->whereHas($column->getWhereHas(), function ($query) use ($column, $filterValues) {
                    foreach ($filterValues as $value) {
                        $query->where($column->getWhereClause(), $column->getOperator(), "%$value%");
                    }
                });
            } else if (is_null($column->getWhereHas())) {
                $queryBuilder = $queryBuilder->where(function ($query) use ($filterValues, $column) {
                    $attributeName = ($column->getWhereClause() ?? $column->getAttribute()); 
                    if($column->getType('daterange')) {
                        if(str_contains($filterValues[0], ','))
                            $filterValues = explode(',', $filterValues[0]); 
                        if(count($filterValues) == 1) {
                            $query->orWhereDate($attributeName, $filterValues[0]);
                        } else {
                            $query->orWhereBetween($attributeName, [$filterValues[0], $filterValues[1]]);  
                        }
                    } else {
                        foreach ($filterValues as $value) {
                            if ($column->getType('date')) {
                                $query->orWhereDate($attributeName, $value);
                            } else {
                                $query->orWhere($attributeName, $column->getOperator(), "%$value%");
                            }
                        }
                    }
                });
            }
        }

        return $queryBuilder;
    }
}
