<?php

namespace Debva\Datatables\Classes;

use Debva\Datatables\Http\Request;

trait Filtering
{
    public function performFiltering(Request $request, $queryBuilder)
    {
        $columnFilters = $request->getColumnFilters();

        // if ($this->canBeFiltered($column) and array_key_exists($column->getAttribute(), $columnFilters)) {

        //     $filterValues = $columnFilters[$column->getAttribute()];

        //     if (!is_array($filterValues)) {
        //         $filterValues = [$filterValues];
        //     }

        //     /** @var Filterable|Column $column */
        //     $queryBuilder = $column->filter($queryBuilder, $filterValues);
        // }
        // return $queryBuilder->where(function ($query) use ($values) {
        //     foreach ($values as $value) {
        //         $attributeName = $this->getWhereClauseAttribute();
        //         if ($this->getType() === 'date') {
        //             $query->orWhereDate($attributeName, $value);
        //         } else {
        //             $query->orWhere($attributeName, 'LIKE', "%$value%");
        //         }
        //     }
        // });
        return $queryBuilder;
    }
}
