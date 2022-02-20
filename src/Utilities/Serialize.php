<?php

namespace Debva\LaravelDatatables\Utilities;

trait Serialize
{
    protected function toBootstrapVue(?array $children = null): array
    {
        $result = [
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

        switch ($this->getType()) {
            case 'blank':
                return [
                    'label' => $this->name,
                    'key' => $this->attribute,
                ];
            case 'select':
                return array_merge($result, [
                    'options' => $this->options,
                ]);
            case 'date':
                unset($result['searchable']);
                return $result;
            case 'group':
                return [
                    'label'     => $this->name,
                    'type'      => $this->type,
                    'children'  => $children,
                ];
        }

        if (!is_null($this->getWhereHas())) {
            $result['sortable'] = false;
        }

        return $result;
    }

    public function groupSerialize(array $children): array
    {
        return $this->toBootstrapVue($children);
    }

    public function textSerialize()
    {
        return $this->toBootstrapVue();
    }

    public function selectSerialize()
    {
        return $this->toBootstrapVue();
    }

    public function dateSerialize()
    {
        return $this->toBootstrapVue();
    }

    public function blankSerialize()
    {
        return $this->toBootstrapVue();
    }
}
