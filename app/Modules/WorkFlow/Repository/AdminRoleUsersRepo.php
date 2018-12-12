<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\AdminRoleUsers;
use App\Common\Contracts\Repository;

class AdminRoleUsersRepo extends Repository{
    public function __construct(AdminRoleUsers $model)
    {
        $this->model = $model;
    }
}