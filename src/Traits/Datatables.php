<?php

namespace Debva\Datatables\Traits;

use Illuminate\Database\Eloquent\Model;
use Debva\Datatables\Http\Requests\DatatablesRequest;
use Debva\Datatables\Http\Responses\DatatablesResponse;

trait Datatables
{
    private function setupQueryBuilder($queryBuilder)
    {
        if ($queryBuilder instanceof Model) {
            return $queryBuilder::query();
        }
        return $queryBuilder;
    }

    public function getColumns()
    {
        return app(DatatablesResponse::class)->columns($this->setColumns());
    }

    public function getDatatables(DatatablesRequest $request)
    {
        $queryBuilder = $this->setupQueryBuilder($this->setQuery());
        $columns = $this->setColumns();

        $queryBuilder = $this->performFiltering($request, $columns, $queryBuilder);
        $queryBuilder = $this->performSearching($request, $columns, $queryBuilder);
        $queryBuilder = $this->performSorting($request, $columns, $queryBuilder);

        $total = $queryBuilder->count();
        $rows = $queryBuilder
            ->limit($perPage = $request->getPerPage())
            ->offset($perPage * ($request->getPage() - 1))
            ->get();

        return app(DatatablesResponse::class)->datatables($request, $columns, $rows, $total);
    }
}
