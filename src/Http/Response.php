<?php

namespace Debva\Http;

class Response
{
    public static function create($paginate, $cols)
    {
        $columns = [];
        foreach ($cols as $col) {
            $childCols = self::nestedColumnGroup($col);
            $columns[] = $col->{$col->getType() . 'Serialize'}($childCols);
        }

        $data = [];
        foreach ($paginate['data'] as $pdata) {
            $values = [];
            foreach ($cols as $col) {
                if ($col->getType('group')) {
                    $nestedData = self::nestedDataGroup($col, $pdata);
                    $values = array_merge($values, $nestedData);
                } else {
                    $values[$col->getAttribute()] = $col->getData($pdata);
                }
            }
            $data[] = $values;
        }

        return [
            'config' => [
                'columns' => $columns
            ],
            'data' => [
                'data' => $data,
                'perPage' => Request::getPerPage(),
                'total' => $paginate['total'],
            ]
        ];
    }

    protected static function nestedColumnGroup($column)
    {
        if ($children = $column->getChildren()) {

            $columns = [];
            foreach ($children as $child) {
                if ($child->getType('group')) {
                    $nestedColumn = self::nestedColumnGroup($child);
                    $columns[] = $child->{$child->getType() . 'Serialize'}($nestedColumn);
                } else {
                    $columns[] = $child->{$child->getType() . 'Serialize'}();
                }
            }
        }

        return $columns ?? null;
    }

    protected static function nestedDataGroup($column, $pdata)
    {
        if ($children = $column->getChildren()) {

            $data = [];
            foreach ($children as $child) {
                if ($child->getType('group')) {
                    $nestedData = self::nestedDataGroup($child, $pdata);
                    $data = array_merge($data, $nestedData);
                } else {
                    $data[$child->getAttribute()] = $child->getData($pdata);
                }
            }
        }

        return $data ?? [];
    }
}
