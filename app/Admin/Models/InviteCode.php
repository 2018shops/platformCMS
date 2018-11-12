<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 14:31
 */

namespace App\Admin\Models;




use Illuminate\Database\Eloquent\Model;

class InviteCode extends Model
{
    public $timestamps = true;
    protected $table = 'invite_code';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function use()
    {
        return $this->hasOne(CommUser::class,'id','use_user_id');
    }
    public function invite()
    {
        return $this->hasOne(CommUser::class,'id','old_user_id');
    }
    public function new()
    {
        return $this->hasOne(CommUser::class,'id','user_id');
    }
}