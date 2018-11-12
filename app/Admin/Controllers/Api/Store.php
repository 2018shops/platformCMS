<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/15
 * Time: 09:38
 */
namespace App\Admin\Controllers\Api ;
use App\Admin\Models\Store as StoreModel;
use App\Admin\Models\StoreStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Store extends Controller {

    public function getStores(Request $request)
    {
        $q = $request->input('q');
        return  StoreModel::where('title','like','%'.$q.'%')
            ->paginate(null,['id','title as text']);
        
    }


    public function getStocks(Request $request)
    {
        $q = $request->input('q');
        return  StoreStock::where('title','like','%'.$q.'%')
            ->paginate(null,['id','title as text']);
    }
}