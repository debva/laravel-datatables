<?php

namespace Debva\Actions;

use Debva\Http\Request;

class Paginating
{
    public static function create($query)
    {
        return [
            'data' => $query->limit($perPage = Request::getPerPage())
                ->offset($perPage * (Request::getPage() - 1))
                ->get(),
            'total' => $query->count(),
        ];
    }
}
