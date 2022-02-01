<?php

namespace Debva\Datatables\Traits;

use Debva\Datatables\Http\Requests\DatatablesRequest;

trait Searching
{
    public function performSearching(DatatablesRequest $request, $columns, $queryBuilder)
    {
        $q = $request->getSearchQuery();
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
