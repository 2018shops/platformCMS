<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/9
 * Time: 11:30
 */
namespace App\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class UserAcctFinance extends Model{


    protected $table = "acct_account_balance";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public function user()
    {
        return $this->hasOne(CommUser::class,'id','process_id');
    }
    public function paginate()
    {
        $perPage = Request::get('per_page', 10);

        $page = Request::get('page', 1);

        $start = ($page-1)*$perPage;

        // 运行sql获取数据数组
        $sql = 'select t0.*,t1.user_name,t1.login_name from acct_account_balance as t0  LEFT join comm_user_info as t1 on t1.short_name = '."'"."system"."'".' where t0.process_id = t1.id';

        $result = DB::select($sql);

        $movies = static::hydrate($result);

        $paginator = new LengthAwarePaginator($movies, $start, $perPage);

        $paginator->setPath(url()->current());

        return $paginator;
    }

    public static function with($relations)
    {
        return new static;
    }
}