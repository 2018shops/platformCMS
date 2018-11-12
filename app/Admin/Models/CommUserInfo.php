<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class CommUserInfo extends Model
{
    public $timestamps = true;
    protected $table = 'comm_user_info';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';


//    public function trans()
//    {
//
//        return $this->hasOne(TranTransOrder::class,'id','user_id');
//    }

}
