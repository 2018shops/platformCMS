<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/12
 * Time: 18:28
 */

namespace App\Admin\Controllers\Api ;

use App\Admin\Models\City as CityModel;
use App\Admin\Models\Province as ProvinceModel ;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class City extends Controller {


    public function getProvince()
    {
        return ProvinceModel::orderBy('sort','ASC')
            ->get(['id','name as text'])->toArray();
    }

    public function getCity(Request $request)
    {
        return  CityModel::where('parentid','=',$request->input('q'))
                ->orderBy('sort','ASC')
                ->get(['id','name as text'])
                ->toArray();
    }

}