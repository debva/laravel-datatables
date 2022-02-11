<?php

namespace Debva\Http;

use Illuminate\Support\Facades\Validator;

class Request
{
    protected $validator;

    public function __construct()
    {
        $this->validator = Validator::make($_REQUEST, [
            'page'          => 'integer',
            'perPage'       => 'integer',
            'columnFilters' => 'array',
            'sort.field'    => 'filled',
            'sort.type'     => 'filled|in:asc,desc',
            'q'             => 'filled'
        ])->validated();
    }

    public static function __callStatic($method, $arguments)
    {
        if (startsWith($method, 'get')) {
            return (new static)->{substr($method, 3)}(...$arguments);
        }
    }

    protected function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->validator) ? $this->validator[$key] : $default;
    }

    protected function perPage(): int
    {
        return $this->get('perPage', 10);
    }

    protected function page(): int
    {
        return $this->get('page', 1);
    }

    protected function columnFilters(): array
    {
        $columnFilters = $this->get('columnFilters', []);
        $columnFilters = collect($columnFilters)
            ->filter(function ($value) {
                return !empty($value);
            })->all();

        return $columnFilters;
    }

    protected function sort(): array
    {
        return $this->get('sort', []);
    }

    protected function searchQuery(): ?string
    {
        return $this->get('q');
    }
}
