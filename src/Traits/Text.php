<?php

namespace Debva\Datatables\Traits;

trait Text
{
    public static function text(...$args)
    {
        return new static('text', ...$args);
    }

    public function jsonSerialize()
    {
        return [
            'key'           => $this->attribute,
            'label'         => $this->name,
            'type'          => $this->type,
            'filterable'    => $this->filterable,
            'searchable'    => $this->searchable,
            'sortable'      => $this->sortable,
        ];
    }
}
