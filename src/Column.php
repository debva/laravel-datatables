<?php

namespace Debva\Datatables;

use Debva\Datatables\Columns\{Blank, Boolean, Date, Number, Select, Text};

class Column
{
    use Blank, Boolean, Date, Number, Select, Text;

    private $name;

    private $attribute;

    private $type;

    private $connection;

    private $filterable = false;

    private $searchable = false;

    private $sortable = false;

    private $placeholder;

    private $whereClauseAttribute;

    private $with;

    private static $instance = true;
    
    public function __construct(string $type, string $name, ?string $attribute = null)
    {
        self::$instance = false;
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
        if (!$this->getType(['date'])) {
            $this->searchable = $searchable;
            return $this;
        }
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

    public function with(string $with)
    {
        $this->with = $with;
        return $this;
    }

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getType($type = null)
    {
        if (is_array($type)) {
            return in_array($this->type, $type);
        }
        return $type ? $this->type === $type : $this->type;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function getOperator()
    {
        return $this->connection === 'pgsql' ? 'ILIKE' : 'LIKE';
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

    public function getWith()
    {
        return $this->with;
    }

    public function getValue($row)
    {
        if ($this->getWith()) {
            if ($row->{$this->getWith()} instanceof Collection) {
                $data = [];
                foreach ($row->{$this->getWith()} as $relation) {
                    $data[] = $relation->{$this->getWhereClauseAttribute()};
                }
            } else {
                $data = data_get($row->{$this->getWith()}, $this->getWhereClauseAttribute());
            }
        } else {
            $data = data_get($row, $this->getWhereClauseAttribute());
        }

        if ($this->getType('date')) {
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

        if (!$this->getType(['date'])) {
            $response = array_merge($response, [
                'searchable' => $this->searchable,
            ]);
        }

        if ($this->getType(['blank'])) {
            return $this->name;
        }

        return $response;
    }
}
