<?php

namespace Debva\Datatables;

use Debva\Datatables\Traits\{Datatables, Filtering, Searching, Sorting};

trait InteractsWithDatatables
{
    use Datatables, Filtering, Searching, Sorting;

    abstract protected function setQuery(): object;

    abstract protected function setColumns(): array;
}
