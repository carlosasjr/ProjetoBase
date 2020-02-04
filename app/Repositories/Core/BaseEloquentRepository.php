<?php

namespace App\Repositories\Core;

use App\Repositories\Contracts\RepositoryInterface;
use App\Repositories\Exceptions\NotModelDefined;

/**
 * .class [ TIPO ]
 *
 * @copyright (c) 2018, Carlos Junior
 */
class BaseEloquentRepository implements RepositoryInterface
{
    protected $model;
    protected $with = [];

    /*     * ************************************************ */
    /*     * ************* METODOS PRIVADOS ***************** */
    /*     * ************************************************ */
    private function resolveModel()
    {
        if (!method_exists($this, 'model')) {
            throw new NotModelDefined;
        }

        return app($this->model());
    }

    /*     * ************************************************ */
    /*     * ************* METODOS PUBLICOS ***************** */
    /*     * ************************************************ */

    /**
     * BaseEloquentRepository constructor.
     * @throws NotModelDefined
     */
    public function __construct()
    {
        $this->model = $this->resolveModel();
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->model->find($id);

    }

    /**
     * @param $column
     * @param string $operator
     * @param $value
     * @return mixed
     */
    public function where($column, $operator = '=', $value)
    {
        return $this->model->where($column, $operator, $value)
                           ->get();
    }

    /**
     * @param $column
     * @param string $operator
     * @param $value
     * @return mixed
     */
    public function whereFirst($column, $operator = '=', $value)
    {
        return $this->model->where($column, $operator, $value)
                           ->first();
    }

    /**
     * @param int $totalPage
     * @return mixed
     */
    public function paginate($totalPage = 10)
    {
       return $this->model->paginate($totalPage);
    }


    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data)
    {
        $model = $this->find($id);

        return $model->update($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $model = $this->find($id);

        return $model->delete();
    }

    /**
     * @param $column
     * @param string $order
     * @return $this
     */
    public function orderBy($column, $order = 'DESC')
    {
        $this->model = $this->model->orderBy($column, $order);

        return $this;
    }

    /**
     * @param mixed ...$relationships
     * @return $this
     */
    public function relationships($relationships)
    {
        $this->model = $this->model->with($relationships);

        return $this;
    }



    /**
     * @param $column
     * @param $view
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function dataTables($column, $view)
    {
      return Datatables()->eloquent($this->model->query())->addColumn($column, $view)
                                                          ->make(true);
    }


}
