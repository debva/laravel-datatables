<?php

namespace Debva\Datatables\Columns;

trait Number
{
    public static function number(...$args)
    {
        abort_if(!static::$instance, 500, 'Double Column');
        return new static('number', ...$args);
    }
}
