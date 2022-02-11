<?php

namespace Debva\Actions;

use Debva\Http\Request;

class Filtering
{
    public static function create($queryBuilder, $columns)
    {
        $columnFilters = Request::getColumnFilters();

        foreach ($columns as $column) {
            if ($column->isFilterable() and array_key_exists($column->getAttribute(), $columnFilters)) {

                $filterValues = $columnFilters[$column->getAttribute()];

                if (!is_array($filterValues)) {
                    $filterValues = [$filterValues];
                }

                $queryBuilder = $queryBuilder->where(function ($query) use ($filterValues, $column) {
                    foreach ($filterValues as $value) {
                        $attributeName = $column->getWhereClauseAttribute();
                        if ($column->getType() === 'date') {
                            $query->orWhereDate($attributeName, $value);
                        } else {
                            $query->orWhere($attributeName, $column->getOperator(), "%$value%");
                        }
                    }
                });
            }
        }

        return $queryBuilder;
    }
}
