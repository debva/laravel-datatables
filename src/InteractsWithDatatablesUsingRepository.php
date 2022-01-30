<?php

namespace Debva\Datatables;

use Illuminate\Database\Eloquent\Model;
use Debva\Datatables\Http\Requests\DatatablesRequest;
use Debva\Datatables\Http\Responses\DatatablesResponse;
use Debva\Datatables\Classes\{Filtering, Searching, Sorting};

trait InteractsWithDatatablesUsingRepository
{
    use Filtering, Searching, Sorting;

    protected function setQuery(): object
    {
        if (is_object($this->repository) and method_exists($this->repository, 'setQuery')) {
            return $this->repository->setQuery();
        }
        abort(404);
    }

    protected function setColumns(): array
    {
        if (is_object($this->repository) and method_exists($this->repository, 'setColumns')) {
            return $this->repository->setColumns();
        }
        abort(404);
    }

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

        $queryBuilder = $this->performFiltering($request, $queryBuilder);
        $queryBuilder = $this->performSearching($request, $queryBuilder);
        $queryBuilder = $this->performSorting($request, $queryBuilder);

        $total = $queryBuilder->count();
        $rows = $queryBuilder
            ->limit($perPage = $request->getPerPage())
            ->offset($perPage * ($request->getPage() - 1))
            ->get();

        return app(DatatablesResponse::class)->datatables($request, $columns, $rows, $total);
    }
}
