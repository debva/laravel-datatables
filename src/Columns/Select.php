<?php

namespace Debva\Datatables\Columns;

trait Select
{
    public static function select(...$args)
    {
        return new static('select', ...$args);
    }
}
