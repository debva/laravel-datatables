<?php

namespace Debva\Tables;

use Debva\Utilities\{
    Builder,
    Connection,
    Date,
    Filterable,
    Footer,
    Group,
    Searchable,
    Serialize,
    Sortable
};

class Column
{
    use Builder,
        Connection,
        Date,
        Filterable,
        Footer,
        Group,
        Searchable,
        Serialize,
        Sortable;

    protected $name;

    protected $attribute;

    protected $type;

    protected $html;

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
}
