<?php

namespace Debva\Datatables\Traits;

use Debva\Datatables\Http\Requests\DatatablesRequest;

trait Searching
{
    abstract protected function setColumns(): array;

    public function performSearching(DatatablesRequest $request, $queryBuilder)
    {
        $sq = $request->getSearchQuery();
        if (empty($sq)) {
            return $queryBuilder;
        }

        $columns = $this->setColumns();
        $queryBuilder->where(function ($query) use ($columns, $sq) {
            foreach ($columns as $column) {
                if ($column->isSearchable()) {
                    $query->orWhere($column->getWhereClauseAttribute(), ($column->getConnection() == 'mysql' ? 'like' : 'ilike'), "%{$sq}%");
                }
            }
        });

        return $queryBuilder;
    }
}
