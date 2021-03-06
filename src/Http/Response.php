<?php

namespace Debva\LaravelDatatables\Http;

class Response
{
    public static function create($paginate, $total, $cols)
    {
        $thead = self::nestedThead($cols);

        $columns = self::nestedColumns($cols);

        $data = [];
        foreach ($paginate as $pdata) {
            $values = [];
            foreach ($cols as $col) {
                if ($col->getExtraData()) {
                    if (is_array($col->getExtraData())) {
                        foreach ($col->getExtraData() as $extraData) {
                            $values[$extraData] = $col->getData($pdata, $extraData);
                        }
                    } else {
                        $values[$col->getExtraData()] = $col->getData($pdata, $col->getExtraData());
                    }
                }

                if ($col->getType('group')) {
                    $nestedData = self::nestedDataGroup($col, $pdata);
                    $values = array_merge($values, $nestedData);
                } else {
                    if (!$col->getType('blank')) {
                        $values[$col->getAttribute()] = $col->getData($pdata);
                    }
                }
            }
            $data[] = $values;
        }

        return [
            'config' => [
                'thead' => $thead,
                'columns' => $columns
            ],
            'data' => [
                'data' => $data,
                'perPage' => Request::getPerPage(),
                'total' => $total,
            ]
        ];
    }

    protected static function nestedThead($columns, $level = 0)
    {
        $level = $level;
        $group = [];
        $thead = [];
        $wrap = [];

        foreach ($columns as $index => $column) {
            if ($column->getType('group')) {
                $group[] = $index;
            }
            $wrap[] = [
                'key' => $column->getAttribute(),
                'label' => $column->getName(),
                'type' => $column->getType(),
                'sortable' => $column->isSortable(),
                'colspan' => $column->getColspan(),
                'rowspan' => $column->getRowspan(),
            ];
        }

        $thead[] = $wrap;

        if (count($group) > 0) {
            $children = [];

            foreach ($group as $index) {
                $children = array_merge($children, $columns[$index]->getChildren());
            }

            if ($level == 0) {
                $thead = array_merge($thead, self::nestedThead($children, $level++));
            } else {
                array_push($thead, self::nestedThead($children, $level++));
            }
        }

        return $thead;
    }

    protected static function nestedColumns($cols)
    {
        $columns = [];
        foreach ($cols as $col) {
            if ($col->getType('group')) {
                $columns = array_merge($columns, self::nestedColumns($col->getChildren()));
            } else {
                $columns[] = $col->{$col->getType() . 'Serialize'}();
            }
        }
        return $columns;
    }

    protected static function nestedDataGroup($column, $pdata)
    {
        if ($children = $column->getChildren()) {

            $data = [];
            foreach ($children as $child) {
                if ($child->getExtraData()) {
                    if (is_array($child->getExtraData())) {
                        foreach ($child->getExtraData() as $extraData) {
                            $data[$extraData] = $child->getData($pdata, $extraData);
                        }
                    } else {
                        $data[$child->getExtraData()] = $child->getData($pdata, $child->getExtraData());
                    }
                }

                if ($child->getType('group')) {
                    $nestedData = self::nestedDataGroup($child, $pdata);
                    $data = array_merge($data, $nestedData);
                } else {
                    if (!$child->getType('blank')) {
                        $data[$child->getAttribute()] = $child->getData($pdata);
                    }
                }
            }
        }

        return $data ?? [];
    }
}
