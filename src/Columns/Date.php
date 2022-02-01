<?php

namespace Debva\Datatables\Columns;

trait Date
{
    protected $dateOutputFormat = '%A, %d %B %Y %H:%m:%S';

    public static function date(...$args)
    {
        abort_if(!static::$instance, 500, 'Double Column');
        return new static('date', ...$args);
    }

    public function dateOutputFormat(string $format)
    {
        $this->dateOutputFormat = $format;
        return $this;
    }
}
