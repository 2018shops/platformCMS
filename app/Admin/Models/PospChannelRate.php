<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class PospChannelRate extends Model
{
    public $timestamps = true;
    protected $table = 'posp_channel_rate';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

}