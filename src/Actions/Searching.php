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
                if ($column->isSearchable()) {
                    $query->orWhere($column->getWhereClauseAttribute(), $column->getOperator(), "%{$q}%");
                }
            }
        });

        return $queryBuilder;
    }
}
