<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/25
 * Time: 11:20
 */

namespace App\Admin\Controllers\Goods;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\ExcelOrder;
use App\Admin\Models\GoodsOrder;
use App\Admin\Models\GoodsInfo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use App\Modules\WorkFlow\WorkFlow;

class GoodsOrderController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('商品全部订单');
            $content->description('商品全部订单');
            $content->body($this->grid());
        });
    }


    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('订单详情');
            $content->description('订单详情');
            $content->body($this->detail()->view($id));
        });
    }
    public function grid()
    {
        return Admin::grid(GoodsOrder::class, function (Grid $grid){
            
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->disableExport();

            $username = Admin::user()->username;
            $store =  WorkFlow::service('StoreService')
                ->with('admin_user',$username)
                ->run('getStoreInfoByAdminUser');
                
            if($store){
                $grid->model()
                ->where('store_id',$store['id'])
                ->orderBy('create_time', 'desc');
            }else{
                $grid->model()
                ->orderBy('create_time', 'desc');
            }


            $grid->model()->orderBy('create_time', 'desc');

            $grid->model()->where('goods_order.state', '!=', '50');
//            $grid->model()->where('goods_type', '=', '10');

            $grid->column('id','ID')->sortable()->display(function ($user_name) {
                return "<a href='/admin/goodsorder/info/{$this->getKey()}' class=''><b>$user_name</b></a>";
            });
            $grid->column('goods_id','商品编号')->sortable();
            $grid->column('goods.name','商品名称')->sortable();
            $grid->column('goods_id','店铺名称')->sortable()->display(function ($goods_id){
                return GoodsInfo::getStoreName($goods_id);
            });
            $grid->column('unit_price','单价')->sortable();
            $grid->column('total_price','总价')->sortable();
            $grid->column('promote_profit','推广分润')->sortable();
            $grid->column('number','数量')->sortable();
            $grid->column('address','收货地址')->limit(20)->sortable();
            $grid->column('consignee_name','收货人姓名')->sortable();
            $grid->column('consignee_mobile','收货人手机号')->sortable();
            $grid->column('user_id','用户编号')->sortable();
            $grid->column('user.user_name','用户名')->sortable();
            $grid->column('goodspay.update_time','订单支付时间');
            $grid->column('state','订单状态')
                ->display(function($state){
                    return config('product.state.'.$state);
                })->sortable();
            $grid->column('goods_type','商品类型')
                ->display(function($goods_type){
                    return config('product.goods_type.'.$goods_type);
                })->sortable();
            $grid->column('goods_class','活动商品类')
                ->display(function($goods_class){
                    return config('product.goods_class.'.$goods_class);
                })->sortable();
            $grid->column('export_status','导出状态')
                ->display(function($export_status){
                    return config('product.export_status.'.$export_status);
                })->sortable();
            $grid->column('update_time','订单更新时间')->sortable();
            $grid->exporter(new ExcelOrder());
            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('address','收货地址');
                $filter->like('goods_id','商品编号');
                $filter->like('state','订单状态')->select(config('product.state'));
            });

            $grid->paginate(15);
        });
    }

    private function detail()
    {
        return Admin::form(GoodsOrder::class,function(Form $form){

                $form->display('consignee_name','收货人姓名');
                $form->display('consignee_mobile','收货人手机号');
                $form->display('address','收货地址');
                $form->display('unit_price','单价');
                //列表常规内容
                $form->disableSubmit();//隐藏保存按钮
                $form->disableReset(); //去掉重置按钮
                //审批  testing...
            });
    }



}