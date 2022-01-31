<?php


namespace Debva\Datatables\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DatatablesRequest
{
    private $validator;

    public function __construct(Request $request)
    {
        $this->validator = Validator::make($request->all(), [
            'page'          => 'integer',
            'perPage'       => 'integer',
            'columnFilters' => 'array',
            'sort.field'  => 'filled',
            'sort.type'   => 'filled|in:asc,desc',
            'q'             => 'nullable'
        ])->validated();
    }

    private function get(string $key, $default = null)
    {
        return array_key_exists($key, $this->validator) ? $this->validator[$key] : $default;
    }

    public function getPerPage(): int
    {
        return $this->get('perPage', 10);
    }

    public function getPage(): int
    {
        return $this->get('page', 1);
    }

    public function getColumnFilters(): array
    {
        $columnFilters = $this->get('columnFilters', []);
        $columnFilters = collect($columnFilters)
            ->filter(function ($value, $key) {
                return !empty($value);
            })->all();

        return $columnFilters;
    }

    public function getSort(): array
    {
        return $this->get('sort', []);
    }

    public function getSearchQuery(): ?string
    {
        return $this->get('q');
    }
}
