<?php
namespace App\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class AcctUserTariffRate extends Model
{
    public $timestamps = true;
    protected $table = 'acct_user_tariff_rate';
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public function level()
    {
        return $this->hasOne(AcctTariffProduct::class,'tariff_code','user_tariff_code');
    }
}