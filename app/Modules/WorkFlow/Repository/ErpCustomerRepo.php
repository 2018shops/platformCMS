<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\Customer;
use App\Common\Contracts\Repository;

class ErpCustomerRepo extends Repository{
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }

    public function update($id, $attributes)
    {
        return $this->model->where('id',$id)->update($attributes);
    }
}