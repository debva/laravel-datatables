<?php

namespace Debva\LaravelDatatables\Tables;

use Debva\LaravelDatatables\Utilities\{
    Ability,
    Builder,
    Connection,
    Date,
    Footer,
    Group,
    Select,
    Serialize,
};

class Column
{
    use Ability,
        Builder,
        Connection,
        Date,
        Footer,
        Group,
        Select,
        Serialize;

    protected $name;

    protected $attribute;

    protected $placeholder;

    protected $type;

    protected $html;

    protected $colspan = 1;

    protected $rowspan = 1;

    protected $columnList = [];

    public function __construct()
    {
        $this->columnList = ['blank', 'text', 'select', 'date', 'group'];
    }

    public function __call($method, $arguments)
    {
        if (startsWith($method, 'make')) {
            $methodName = strtolower(substr($method, 4));

            if (in_array($methodName, $this->columnList)) {
                return (new self())->create($methodName, ...$arguments);
            }
            throw new \BadMethodCallException("Method [$methodName] does not exist.");
        }
    }

    /**
     * @param string $type
     * @param string $name
     * @param string|\Closure|null $attribute
     * 
     * @return $this
     */
    protected function create(string $type, string $name, $attribute = null)
    {
        $this->type = $type;
        $this->name = $name;
        $this->setConnection();

        if ($attribute instanceof \Closure) {
            return $this->group($attribute);
        }

        $this->attribute = $attribute ?? str_replace([' ', '.'], '_', strtolower($name));
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param string|array|null $type
     * 
     * @return string
     */
    public function getType($type = null): string
    {
        if (is_array($type)) {
            return in_array($this->type, $type);
        }
        return $type ? $this->type === $type : $this->type;
    }

    /**
     * @param \Closure $html
     * 
     * @return $this
     */
    public function html(\Closure $html)
    {
        $this->html = $html;
        return $this;
    }

    /**
     * @param string $colspan
     * 
     * @return $this
     */
    public function placeholder(string $placeholder)
    {
        $this->placeholder = $placeholder;
        return $this;
    }

    /**
     * @param int $colspan
     * 
     * @return $this
     */
    public function span(int $colspan = 1, int $rowspan = 1)
    {
        $this->colspan = $colspan;
        $this->rowspan = $rowspan;
        return $this;
    }

    /**
     * @return int
     */
    public function getColspan(): int
    {
        return $this->colspan;
    }

    /**
     * @return int
     */
    public function getRowspan(): int
    {
        return $this->rowspan;
    }
}
