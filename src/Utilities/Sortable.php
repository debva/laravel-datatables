<?php

namespace Debva\Utilities;

trait Sortable
{
    protected $sortable = false;
    
    /**
     * @param bool|null $sortable
     * 
     * @return $this
     */
    public function sortable(?bool $sortable = true)
    {
        $this->sortable = $sortable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSortable(): bool
    {
        return $this->sortable;
    }
}
