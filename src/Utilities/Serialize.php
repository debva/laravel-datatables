<?php

namespace Debva\LaravelDatatables\Utilities;

trait Serialize
{
    protected function toBootstrapVue(): array
    {
        return [
            'label'         => $this->name,
            'key'           => $this->attribute,
            'type'          => $this->type,
            'filterable'    => $this->filterable,
            'searchable'    => $this->searchable,
            'sortable'      => $this->sortable,
            'html'          => $this->html ? true : false,
            'footer'        => $this->footer,
        ];
    }

    public function groupSerialize(?array $children = null): array
    {
        $result = $this->toBootstrapVue();
        unset($result['key'], $result['filterable'], $result['searchable'], $result['sortable'], $result['html'], $result['footer']);
        return array_merge($result, [
            'children' => $children,
        ]);
    }

    public function textSerialize()
    {
        return $this->toBootstrapVue();
    }

    public function dateSerialize()
    {
        $result = $this->toBootstrapVue();
        unset($result['searchable']);
        return $result;
    }

    public function blankSerialize()
    {
        return $this->name;
    }
}
