<?php

namespace Debva\Actions;

use Debva\Http\Request;

class Searching
{
    public static function create($queryBuilder, $columns)
    {
        $q = Request::getSearchQuery();
        if (empty($q)) {
            return $queryBuilder;
        }

        $queryBuilder->where(function ($query) use ($columns, $q) {
            foreach ($columns as $column) {
                if ($column->getType('group')) {
                    foreach ($column->getChildren() as $child) {
                        self::searching($query, $child, $q);
                    }
                } else {
                    self::searching($query, $column, $q);
                }
            }
        });

        return $queryBuilder;
    }

    protected static function searching($queryBuilder, $column, $q)
    {
        if ($column->isSearchable()) {
            $queryBuilder->orWhere($column->getWhereClauseAttribute(), $column->getOperator(), "%{$q}%");
        }
    }
}
