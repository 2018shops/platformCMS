<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TranTransOrder extends Model
{
    public $timestamps = true;
    protected $table = 'tran_trans_order';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

    public function user()
    {
        return $this->hasOne(CommUser::class,'id','user_id');
    }

    public function code()
    {
        return $this->hasOne(InviteCode::class,'code','invite_code');
    }
}