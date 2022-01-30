<?php

namespace Debva\Datatables\Traits;

trait Number
{
    public static function number(...$args)
    {
        return new static('number', ...$args);
    }
}
