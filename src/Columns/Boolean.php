<?php

namespace Debva\Datatables\Columns;

trait Boolean
{
    public static function boolean(...$args)
    {
        abort_if(!static::$instance, 500, 'Double Column');
        return new static('boolean', ...$args);
    }
}
