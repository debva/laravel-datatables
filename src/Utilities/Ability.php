<?php

namespace Debva\LaravelDatatables\Utilities;

trait Ability
{
    protected $filterable = false;

    protected $searchable = false;

    protected $sortable = false;

    /**
     * @param bool $filterable
     * 
     * @return $this
     */
    public function ability(bool $filterable = false, bool $searchable = false, bool $sortable = false)
    {
        $this->filterable = $filterable;
        $this->searchable = $searchable;
        $this->sortable = $sortable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }

    /**
     * @return bool
     */
    public function isSearchable(): bool
    {
        if ($this->getType('date')) {
            return false;
        }
        return $this->searchable;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        if ($this->getWhereHas()) {
            return false;
        }
        return $this->sortable;
    }
}
