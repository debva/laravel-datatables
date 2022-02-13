<?php

namespace Debva\LaravelDatatables\Utilities;

trait Group
{
    protected $children;

    protected function group($attribute)
    {
        $attribute = call_user_func($attribute, new self);
        if (is_array($attribute)) {
            $this->children = $attribute;
            return $this;
        }
        throw new \Exception('Group must be an array');
    }

    public function getChildren()
    {
        return $this->children;
    }
}
