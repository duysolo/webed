<?php namespace WebEd\Base\Core\Support\DataTable\Engines;

use WebEd\Base\Core\Repositories\AbstractBaseRepository;
use WebEd\Base\Caching\Repositories\AbstractRepositoryCacheDecorator;
use Yajra\Datatables\Engines\BaseEngine;
use Yajra\Datatables\Request;
use Closure;

class RepositoryEngine extends BaseEngine
{
    /**
     * @var AbstractBaseRepository|AbstractRepositoryCacheDecorator
     */
    protected $repository;

    public function __construct($repository, Request $request)
    {
        if ($repository instanceof AbstractRepositoryCacheDecorator || $repository instanceof AbstractBaseRepository) {
            $this->repository = $repository;
        } else {
            throw new \RuntimeException('Repository must be a instance of ' . AbstractBaseRepository::class . ' or ' . AbstractRepositoryCacheDecorator::class);
        }

        $this->request = $request;
        $this->columns = array_get($this->repository->getQueryBuilderData(), 'select', []);
        $this->connection = $this->repository->getModel()->getConnection();
    }

    /**
     * Check if model use SoftDeletes trait
     *
     * @return boolean
     */
    private function modelUseSoftDeletes()
    {
        $model = $this->repository->getModel();
        if ($model instanceof \Illuminate\Database\Eloquent\SoftDeletes) {
            return true;
        }

        return false;
    }

    public function columnSearch()
    {
        // TODO: Implement columnSearch() method.
        $columns = $this->request->get('columns', []);

        foreach ($columns as $index => $column) {
            if (!$this->request->isColumnSearchable($index)) {
                continue;
            }

            $column = $this->getColumnName($index);
            $keyword = $this->getSearchKeyword($index);

            if ($keyword) {
                $this->repository->where($column, 'LIKE', $keyword);
            }

            $this->isFilterApplied = true;
        }
    }

    public function filtering()
    {
        // TODO: Implement filtering() method.
        $globalKeyword = $this->request->keyword();
        foreach ($this->request->searchableColumnIndex() as $index) {
            $columnName = $this->getColumnName($index);
            if ($this->isBlacklisted($columnName)) {
                continue;
            }
            $keyword = $this->request->get('columns[' . $index . '][search][value]');

            $this->repository->where(function ($q) use ($columnName, $keyword, $globalKeyword) {
                $q
                    ->where($columnName, 'LIKE', $keyword)
                    ->orWhere($columnName, 'LIKE', $globalKeyword);
            });
        }

        $this->isFilterApplied = true;
    }

    public function ordering()
    {
        // TODO: Implement ordering() method.
        foreach ($this->request->orderableColumns() as $orderable) {
            $column = $this->getColumnName($orderable['column'], true);

            if ($this->isBlacklisted($column)) {
                continue;
            }

            $this->repository->orderBy($column, $orderable['direction']);
        }
    }

    public function paging()
    {
        // TODO: Implement paging() method.
        $this->repository->skip($this->request['start'])
            ->take((int)$this->request['length'] > 0 ? $this->request['length'] : 10);
    }

    public function filter(Closure $callback, $globalSearch = false)
    {
        // TODO: Implement filter() method.
        $this->overrideGlobalSearch($callback, $this->repository, $globalSearch);
    }

    public function count()
    {
        // TODO: Implement count() method.
        $repository = clone $this->repository;
        if (!$this->withTrashed && $this->modelUseSoftDeletes()) {
            if ($repository->isUseJoin()) {
                $repository = $repository->where($repository->getModel()->getTable() . '.deleted_at', '=', null);
            } else {
                $repository = $repository->where('deleted_at', '=', null);
            }
        }
        $repository = $repository->get();
        try {
            $total = $repository->total();
        } catch (\Exception $exception) {
            $total = $repository->count();
        }
        return $total;
    }

    public function totalCount()
    {
        // TODO: Implement totalCount() method.
        return $this->totalRecords ? $this->totalRecords : $this->count();
    }

    public function results()
    {
        // TODO: Implement results() method.
        return $this->repository->get();
    }

    /**
     * Get proper keyword to use for search.
     * @param int $i
     * @return string
     */
    private function getSearchKeyword($i)
    {
        $keyword = $this->request->columnKeyword($i);

        return $keyword;
    }
}
