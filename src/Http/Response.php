<?php

namespace Debva\Datatables\Http;

class Response
{
    public function columns($columns)
    {
        $items = [];
        foreach ($columns as $column) {
            $items[] = $column->jsonSerialize();
        }
        return $items;
    }

    public function datatables(Request $request, $rows, $total)
    {
        return [
            'data' => $rows,
            'perPage' => $request->getPerPage(),
            'total' => $total,
        ];
    }
}
