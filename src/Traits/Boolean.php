<?php

namespace Debva\Datatables\Traits;

trait Boolean
{
    public static function boolean(...$args)
    {
        return new static('boolean', ...$args);
    }
}
