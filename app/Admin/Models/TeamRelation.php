<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/14
 * Time: 18:45
 */

namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TeamRelation extends Model{

    protected $table = "team_relation";

    public function user()
    {
        return $this->hasOne(CommUser::class,'id','user_id');
    }
}