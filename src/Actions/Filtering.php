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

            $queryBuilder = $queryBuilder->where(function ($query) use ($filterValues, $column) {
                foreach ($filterValues as $value) {
                    $attributeName = $column->getWhereClause();
                    if ($column->getType() === 'date') {
                        $query->orWhereDate($attributeName, $value);
                    } else {
                        $query->orWhere($attributeName, $column->getOperator(), "%$value%");
                    }
                }
            });
        }

        return $queryBuilder;
    }
}
