<?php

namespace Debva\Datatables\Traits;

trait Date
{
    protected $dateOutputFormat = '%A, %d %B %Y %H:%m:%S';

    public static function date(...$args)
    {
        return new static('date', ...$args);
    }

    public function dateOutputFormat(string $format)
    {
        $this->dateOutputFormat = $format;
        return $this;
    }
}
