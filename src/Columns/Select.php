<?php

namespace Debva\Datatables\Columns;

trait Select
{
    public static function select(...$args)
    {
        abort_if(!static::$instance, 500, 'Double Column');
        return new static('select', ...$args);
    }
}
