<?php

namespace Debva\LaravelDatatables\Utilities;

trait Searchable
{
    protected $searchable = false;
    
    /**
     * @param bool|null $searchable
     * 
     * @return $this
     */
    public function searchable(?bool $searchable = true)
    {
        $this->searchable = $searchable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSearchable(): bool
    {
        return $this->searchable;
    }
}
