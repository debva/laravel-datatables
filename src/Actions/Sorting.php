<?php

namespace Debva\LaravelDatatables\Actions;

use Debva\LaravelDatatables\Http\Request;

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
            if ($column->getType('group')) {
                foreach ($column->getChildren() as $child) {
                    $queryBuilder = self::sorting($queryBuilder, $child, $sortField, $sortType, $isReorder);
                }
            } else {
                $queryBuilder = self::sorting($queryBuilder, $column, $sortField, $sortType, $isReorder);
            }
        }

        return $queryBuilder;
    }

    protected static function sorting($queryBuilder, $column, $sortField, $sortType, $isReorder)
    {
        if ($column->getAttribute() == $sortField and $column->isSortable() and is_null($column->getWhereHas())) {
            $attibuteName = ($column->getWhereClause() ?? $column->getAttribute());
            if ($isReorder) {
                $queryBuilder->reorder($attibuteName, $sortType);
            } else {
                $queryBuilder->orderBy($attibuteName, $sortType);
            }
        }

        return $queryBuilder;
    }
}
