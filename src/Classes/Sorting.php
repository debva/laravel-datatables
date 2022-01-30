<?php

namespace Debva\Datatables\Classes;

use Debva\Datatables\Http\Request;

trait Sorting
{
    public function performSorting(Request $request, $queryBuilder)
    {
        return $queryBuilder;
    }
}
