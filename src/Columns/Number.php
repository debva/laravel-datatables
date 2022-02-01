<?php

namespace Debva\Datatables\Columns;

trait Number
{
    public static function number(...$args)
    {
        return new static('number', ...$args);
    }
}
