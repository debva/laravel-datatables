<?php

namespace Debva\Datatables;

use Debva\Datatables\Traits\{Boolean, Date, Number, Select, Text};

class Column
{
    use Boolean, Date, Number, Select, Text;

    private $name;

    private $attribute;

    private $type;

    private $connection;

    private $filterable = false;

    private $searchable = false;

    private $sortable = false;

    private $placeholder;

    private $whereClauseAttribute;

    public function __construct(string $type, string $name, ?string $attribute = null)
    {
        $this->type = $type;
        $this->name = $this->placeholder = $name;
        $this->attribute = $attribute ?? str_replace([' ', '.'], '_', strtolower($name));
        $this->connection = \DB::connection()->getDriverName();
    }

    public function filterable(?bool $filterable = true)
    {
        $this->filterable = $filterable;
        return $this;
    }

    public function searchable(?bool $searchable = true)
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function sortable(?bool $sortable = true)
    {
        $this->sortable = $sortable;
        return $this;
    }

    public function placeholder(string $placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    public function whereClauseAttribute(string $whereClauseAttribute)
    {
        $this->whereClauseAttribute = $whereClauseAttribute;
        return $this;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function isFilterable()
    {
        return $this->filterable;
    }

    public function isSearchable()
    {
        return $this->searchable;
    }

    public function isSortable()
    {
        return $this->sortable;
    }

    public function getWhereClauseAttribute()
    {
        return $this->whereClauseAttribute ?? $this->attribute;
    }

    public function getValue($row, $attribute = null)
    {
        $data = data_get($row, ($attribute ?? $this->attribute));

        if ($this->type === 'date') {
            $data = strftime($this->dateOutputFormat, strtotime($data));
        }

        return $data;
    }

    public function jsonSerialize()
    {
        $response = [
            'key'           => $this->attribute,
            'label'         => $this->name,
            'type'          => $this->type,
            'filterable'    => $this->filterable,
            'sortable'      => $this->sortable,
        ];

        if (!in_array($this->type, ['date'])) {
            $response = array_merge($response, [
                'searchable'    => $this->searchable,
            ]);
        }

        if (in_array($this->type, ['date'])) {
            $response = array_merge($response, []);
        }

        return $response;
    }
}
