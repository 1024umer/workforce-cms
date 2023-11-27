<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ListRepository implements BaseRepository
{
    protected $model;
    public function bindModel($model)
    {
        $this->model = new $model;
    }
    public function find($id): Model
    {
        return $this->model->find($id);
    }
    public function listFilteredQuery($filter_columns)
    {
        $list = $this->model;
        if (isset($_GET['sortCol'])) {
            $list = $list->orderBy($_GET['sortCol'], ($_GET['sortByDesc'] == 1 ? 'desc' : 'asc'));
        } else {
            $list = $list->orderBy($list->getTable() . '.id', 'desc');
        }
        if (!empty($_GET['search'])) {
            $list = $list->Where(
                function ($query) use ($filter_columns) {
                    $q = $_GET['search'];
                    foreach ($filter_columns as $filter_column) {
                        $query->orWhere($filter_column, 'like', '%' . $q . '%');
                    }
                }
            );
        }
        return $list;
    }
    public function listFiltered($filter_columns)
    {
        $list = $this->listFilteredQuery($filter_columns);
        if (isset($_GET['perpage']) && intval($_GET['perpage']) > 0) {
            $list = $list->paginate($_GET['perpage']);
        } else {
            $list = $list->get();
        }
        return $list;
    }
    public function delete($id)
    {
        $this->model->delete($id);
    }
}