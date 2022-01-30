<?php

namespace Debva\Datatables\Traits;

trait Text
{
    public static function text(...$args)
    {
        return new static('text', ...$args);
    }
}
