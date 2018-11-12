<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AcctTariffProduct extends Model
{
    public $timestamps = true;
    protected $table = 'acct_tariff_product';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';

}