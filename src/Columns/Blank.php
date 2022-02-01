<?php

namespace Debva\Datatables\Columns;

trait Blank
{
    public static function blank($name)
    {
        abort_if(!static::$instance, 500, 'Double Column');
        return new static('blank', $name);
    }
}
