<?php

namespace Debva\LaravelDatatables\Actions;

use Debva\LaravelDatatables\Http\Request;

class Searching
{
    public static function create($queryBuilder, $columns)
    {
        $q = Request::getSearchQuery();
        if (empty($q)) {
            return $queryBuilder;
        }

        $queryBuilder = $queryBuilder->where(function ($query) use ($columns, $q) {
            foreach ($columns as $column) {
                if ($column->getType('group')) {
                    foreach ($column->getChildren() as $child) {
                        $queryBuilder = self::searching($query, $child, $q);
                    }
                } else {
                    $queryBuilder = self::searching($query, $column, $q);
                }
            }

            return $queryBuilder;
        });

        return $queryBuilder;
    }

    protected static function searching($queryBuilder, $column, $q)
    {
        if ($column->isSearchable()) {
            $attibuteName = ($column->getWhereClause() ?? $column->getAttribute());

            if (!is_null($column->getWhereHas()) and !is_null($column->getWhereClause())) {
                return $queryBuilder->orWhereHas($column->getWhereHas(), function ($query) use ($column, $q) {
                    $query->where($column->getWhereClause(), $column->getOperator(), "%{$q}%");
                });
            } else {
                return $queryBuilder->orWhere($attibuteName, $column->getOperator(), "%{$q}%");
            }
        }
    }
}
