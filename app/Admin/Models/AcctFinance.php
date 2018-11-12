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

class AcctFinance extends Model{


    protected $table = "acct_account_balance";
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public function user()
    {
        return $this->hasOne(CommUser::class,'id','process_id');
    }

}