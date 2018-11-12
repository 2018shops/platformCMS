<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class TeamBkgeSet extends Model
{
    public $timestamps = true;
    protected $table = 'team_bkge_set';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

}