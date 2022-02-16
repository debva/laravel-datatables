<?php

namespace Debva\LaravelDatatables\Utilities;

trait Serialize
{
    protected function toBootstrapVue(): array
    {
        return [
            'label'         => $this->name,
            'placeholder'   => $this->placeholder,
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
        return [
            'label'     => $this->name,
            'type'      => $this->type,
            'children'  => $children,
        ];
    }

    public function textSerialize()
    {
        return $this->toBootstrapVue();
    }

    public function selectSerialize()
    {
        return array_merge($this->toBootstrapVue(), [
            'options' => $this->options,
        ]);
    }

    public function dateSerialize()
    {
        $result = $this->toBootstrapVue();
        unset($result['searchable']);
        return $result;
    }

    public function blankSerialize()
    {
        return [
            'label' => $this->name,
            'key' => $this->attribute,
        ];
    }
}
