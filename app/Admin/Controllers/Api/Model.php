<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/15
 * Time: 09:38
 */
namespace App\Admin\Controllers\Api ;
use App\Admin\Models\CoffeeHall;
use App\Admin\Models\FormulaModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Model extends Controller {

    public function getModel(Request $request)
    {
        $q = $request->input('q');
        return  FormulaModel::where('name','like','%'.$q.'%')
            ->paginate(null,['id','name as text']);
        
    }

    public function getCafe(Request $request)
    {
        $q = $request->input('q');
        return  CoffeeHall::where('name','like','%'.$q.'%')
            ->paginate(null,['id','name as text']);
    }

    public function getCafeAll(Request $request){
        return CoffeeHall::get(['id','name as text','user_id'])->toArray();
    }
}