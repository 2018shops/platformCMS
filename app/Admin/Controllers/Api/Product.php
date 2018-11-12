<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/16
 * Time: 09:39
 */
namespace App\Admin\Controllers\Api ;
use App\Admin\Models\ProductFactory;
use App\Admin\Models\ProductFactoryBrand;
use App\Admin\Models\Supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\Models\Product as ProductMoel;

class Product extends Controller {


    public function getProduct(Request $request)
    {
        $q = $request->input('q');
        return ProductMoel::where('title','like','%'.$q.'%')
            ->paginate(null,['id','title as text']);
    }

    //根据title获取factory
    public function getFactory(Request $request)
    {
        $q = $request->input('q');
        return  ProductFactory::where('title','like','%'.$q.'%')
            ->paginate(null,['id','title as text']);
    }

    public function getBrand(Request $request)
    {
        $q = $request->input('q');
        return ProductFactoryBrand::where('factory_id','=',$q)
                ->get(['id','brand_title as text'])
                ->toArray();

    }


    public function getSupplier(Request $request)
    {
        $q = $request->input('q');
        return Supplier::where('title','like','%'.$q.'%')
            ->paginate(null,['id','title as text']);
    }
    
    
}