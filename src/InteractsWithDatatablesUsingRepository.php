<?php

namespace Debva\Datatables;

use Debva\Datatables\Traits\{Datatables, Filtering, Searching, Sorting};

trait InteractsWithDatatablesUsingRepository
{
    use Datatables, Filtering, Searching, Sorting;

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
}
