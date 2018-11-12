<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class InsuranceOrder extends Model
{
    public $timestamps = true;
    protected $table = 'insurance_order';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
}