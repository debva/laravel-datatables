<?php

namespace Debva\Utilities;

trait Filterable
{
    protected $filterable = false;
    
    /**
     * @param bool|null $filterable
     * 
     * @return $this
     */
    public function filterable(?bool $filterable = true)
    {
        $this->filterable = $filterable;
        return $this;
    }

    /**
     * @return bool
     */
    public function isFilterable(): bool
    {
        return $this->filterable;
    }
}
