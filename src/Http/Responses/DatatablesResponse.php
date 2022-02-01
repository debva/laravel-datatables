<?php

namespace Debva\Datatables\Http\Responses;

use Debva\Datatables\Http\Requests\DatatablesRequest;

class DatatablesResponse
{
    public function columns($columns)
    {
        $items = [];
        foreach ($columns as $column) {
            $items[] = $column->jsonSerialize();
        }
        return $items;
    }

    public function datatables(DatatablesRequest $request, $columns, $rows, $total)
    {
        $data = [];
        foreach ($rows as $row) {
            $values = [];
            foreach ($columns as $column) {
                if (!in_array($column->getType(), ['blank'])) {
                    $values[$column->getAttribute()] = $column->getValue($row);
                }
            }
            $data[] = $values;
        }

        return [
            'data' => $data,
            'perPage' => $request->getPerPage(),
            'total' => $total,
        ];
    }
}
