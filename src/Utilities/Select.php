<?php

namespace Debva\LaravelDatatables\Utilities;

trait Select
{
    protected $options = [];

    /**
     * @param array $options
     * 
     * @return $this
     */
    public function options(array $options = [])
    {
        $items = !empty($options) ? [['value' => '', 'text' => $this->placeholder ?? $this->name]] : $options;
        foreach ($options as $option) {
            if (is_array($option)) {
                if (!empty($option) && count($option) <= 2) {
                    if (!array_key_exists('value', $option) && !array_key_exists('text', $option)) {
                        $items[] = ['value' => $option[0], 'text' => $option[1]];
                    } else {
                        $items[] = $option;
                    }
                }
            } else {
                $items[] = ['value' => $option, 'text' => $option];
            }
        }
        $this->options = $items;
        return $this;
    }
}
