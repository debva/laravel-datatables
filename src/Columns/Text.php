<?php

namespace Debva\Datatables\Columns;

trait Text
{
    public static function text(...$args)
    {
        return new static('text', ...$args);
    }
}
