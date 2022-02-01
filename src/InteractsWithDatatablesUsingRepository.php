<?php

namespace Debva\Datatables;

use Debva\Datatables\Traits\{Datatables, Filtering, Searching, Sorting};

trait InteractsWithDatatablesUsingRepository
{
    use Datatables, Filtering, Searching, Sorting;

    protected function setQuery(): object
    {
        abort_if(!isset($this->repository), 500, 'Repository Undefined');
        $this->repository = is_object($this->repository) ? $this->repository : app($this->repository);
        if (method_exists($this->repository, 'setQuery')) {
            return $this->repository->setQuery();
        }
        abort(500, 'Query Undefined');
    }

    protected function setColumns(): array
    {
        abort_if(!isset($this->repository), 500, 'Repository Undefined');
        $this->repository = is_object($this->repository) ? $this->repository : app($this->repository);
        if (method_exists($this->repository, 'setQuery')) {
            return $this->repository->setColumns();
        }
        abort(500, 'Columns Undefined');
    }
}
