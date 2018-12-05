<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\AdminRoles;
use App\Common\Contracts\Repository;

class AdminRolesRepo extends Repository{
    public function __construct(AdminRoles $model)
    {
        $this->model = $model;
    }
}