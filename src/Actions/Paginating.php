<?php

namespace Debva\LaravelDatatables\Actions;

use Debva\LaravelDatatables\Http\Request;

class Paginating
{
    public static function create($query)
    {
        return $query->limit($perPage = Request::getPerPage())
            ->offset($perPage * (Request::getPage() - 1))
            ->get();
    }
}
