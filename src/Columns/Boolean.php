<?php

namespace Debva\Datatables\Columns;

trait Boolean
{
    public static function boolean(...$args)
    {
        return new static('boolean', ...$args);
    }
}
