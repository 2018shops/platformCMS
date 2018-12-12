<?php
namespace App\Modules\WorkFlow\Repository;
use App\Admin\Models\AdminUsers;
use App\Common\Contracts\Repository;
use Illuminate\Support\Facades\DB;

class AdminUsersRepo extends Repository{
    public function __construct(AdminUsers $model)
    {
        $this->model = $model;
    }

    public function insert($data){
        return DB::table('admin_users')->insertGetId($data);
    }
}