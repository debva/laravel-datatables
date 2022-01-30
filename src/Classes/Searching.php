<?php

namespace Debva\Datatables\Classes;

use Debva\Datatables\Http\Request;

trait Searching
{
    public function performSearching(Request $request, $queryBuilder)
    {
        return $queryBuilder;
    }
}
