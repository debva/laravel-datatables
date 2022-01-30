<?php

namespace Debva\Datatables;

use Illuminate\Database\Eloquent\Model;
use Debva\Datatables\Http\{Request, Response};
use Debva\Datatables\Classes\{Filtering, Searching, Sorting};

trait InteractsWithDatatables
{
    use Filtering, Searching, Sorting;

    abstract protected function setQuery();

    abstract protected function setColumns(): array;

    private function setupQueryBuilder($queryBuilder)
    {
        if ($queryBuilder instanceof Model) {
            return $queryBuilder::query();
        }
        return $queryBuilder;
    }

    public function getColumns()
    {
        return app(Response::class)->columns($this->setColumns());
    }

    public function getDatatables(Request $request)
    {
        $queryBuilder = $this->setupQueryBuilder($this->setQuery());
        $columns = $this->setColumns();

        $queryBuilder = $this->performFiltering($request, $queryBuilder);
        $queryBuilder = $this->performSearching($request, $queryBuilder);
        $queryBuilder = $this->performSorting($request, $queryBuilder);

        $total = $queryBuilder->count();
        $rows = $queryBuilder
            ->limit($perPage = $request->getPerPage())
            ->offset($perPage * ($request->getPage() - 1))
            ->get();

        return app(Response::class)->datatables($request, $rows, $total);
    }
}
