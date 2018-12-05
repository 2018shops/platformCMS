<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\AdminUsers;
use App\Common\Contracts\Repository;

class AdminUsersRepo extends Repository{
    public function __construct(AdminUsers $model)
    {
        $this->model = $model;
    }
}