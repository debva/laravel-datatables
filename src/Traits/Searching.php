<?php

namespace Debva\Datatables\Traits;

use Debva\Datatables\Http\Requests\DatatablesRequest;

trait Searching
{
    public function performSearching(DatatablesRequest $request, $queryBuilder)
    {
        $q = $request->getSearchQuery();
        if (empty($q)) {
            return $queryBuilder;
        }

        $queryBuilder->where(function ($query) use ($q) {
            foreach ($this->setColumns() as $column) {
                if ($column->isSearchable()) {
                    $query->orWhere($column->getWhereClauseAttribute(), $column->getOperator(), "%{$q}%");
                }
            }
        });

        return $queryBuilder;
    }
}
