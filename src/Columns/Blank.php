<?php

namespace Debva\Datatables\Columns;

trait Blank
{
    public static function blank($name)
    {
        return new static('blank', $name);
    }
}
