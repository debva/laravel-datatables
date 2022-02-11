<?php

namespace Debva\Actions;

use Debva\Http\Request;

class Sorting
{
    public static function create($queryBuilder, $columns)
    {
        $sort = Request::getSort();
        if (empty($sort)) {
            return $queryBuilder;
        }

        $sortField = $sort['field'];
        $sortType = $sort['type'];

        $isReorder = false;
        if (isset($queryBuilder->orders) or ($queryBuilder instanceof Builder and isset($queryBuilder->getQuery()->orders))) {
            $isReorder = true;
        }

        foreach ($columns as $column) {
            if ($column->getAttribute() == $sortField and $column->isSortable()) {
                if ($isReorder) {
                    $queryBuilder->reorder($column->getWhereClauseAttribute(), $sortType);
                } else {
                    $queryBuilder->orderBy($column->getWhereClauseAttribute(), $sortType);
                }
            }
        }

        return $queryBuilder;
    }
}
