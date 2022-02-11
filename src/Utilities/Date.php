<?php

namespace Debva\Utilities;

trait Date
{
    protected $dateOutputFormat = '%A, %d %B %Y %H:%m:%S';

    /**
     * @param string $format
     * 
     * @return $this
     */
    public function dateOutputFormat(string $format)
    {
        $this->dateOutputFormat = $format;
        return $this;
    }
}
