<?php

namespace Debva\LaravelDatatables\Utilities;

trait Date
{
    protected $dateFormat = '%A, %d %B %Y %H:%m:%S';

    /**
     * @param string $format
     * 
     * @return $this
     */
    public function dateFormat(string $format)
    {
        $this->dateFormat = $format;
        return $this;
    }
}
