<?php

namespace App\Repositories\Contracts;

interface RepositoryInterface
{
    public function get();
    public function find($id);
    public function where($column, $operator = '=', $value);
    public function whereFirst($column,  $operator = '=', $value);
    public function paginate($totalPage = 10);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function orderBy($column, $order = 'DESC');
    public function dataTables($column, $view);
    public function relationships($relationships);
}
