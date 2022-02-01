<?php

namespace Debva\Datatables\Columns;

trait Text
{
    public static function text(...$args)
    {
        abort_if(!static::$instance, 500, 'Double Column');
        return new static('text', ...$args);
    }
}
