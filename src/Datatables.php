<?php

namespace Debva\LaravelDatatables;

use Debva\LaravelDatatables\Http\{Response};
use Debva\LaravelDatatables\Tables\{Column};
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Query\Builder as QueryBuilder;
use Debva\LaravelDatatables\Actions\{Filtering, Paginating, Searching, Sorting};

class Datatables
{
    /**
     * @var Builder|QueryBuilder
     */
    protected $query;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @param \Closure|Model|Builder|QueryBuilder|string $query
     * 
     * @return self
     */
    public static function query($query): self
    {
        if ($query instanceof \Closure) {
            return (new self)->newQuery($query());
        }

        return (new self)->newQuery($query);
    }

    /**
     * @param Model|Builder|QueryBuilder|string $query
     * 
     * @return $this
     */
    protected function newQuery($query): self
    {
        if (is_string($query) and class_exists($query)) {
            $query = new $query;
        }

        if ($query instanceof Model) {
            $query = $query::query();
        }

        if (!$query instanceof Builder and !$query instanceof QueryBuilder) {
            throw new \InvalidArgumentException('Invalid query');
        }

        $this->query = $query;
        return $this;
    }

    /**
     * @param \Closure $columns
     * 
     * @return $this
     */
    public function column(\Closure $columns): self
    {
        $columns = call_user_func($columns, new Column);

        if (is_array($columns)) {
            $this->columns = $columns;
            return $this;
        }

        throw new \Exception('Columns must be an array');
    }

    /**
     * @return array
     */
    public function get(): array
    {
        if (!empty($this->columns)) {
            $queryBuilder = $this->query;
            $queryBuilder = Filtering::create($queryBuilder, $this->columns);
            $queryBuilder = Searching::create($queryBuilder, $this->columns);
            $queryBuilder = Sorting::create($queryBuilder, $this->columns);
            $total        = $queryBuilder->count();
            $queryBuilder = Paginating::create($queryBuilder);
            return Response::create($queryBuilder, $total, $this->columns);
        }

        throw new \Exception('Columns must be defined');
    }
}
