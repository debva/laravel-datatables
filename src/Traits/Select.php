<?php

namespace Debva\Datatables\Traits;

trait Select
{
    public static function select(...$args)
    {
        return new static('select', ...$args);
    }
}
