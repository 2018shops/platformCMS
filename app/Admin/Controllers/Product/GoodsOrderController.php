<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/25
 * Time: 11:20
 */

namespace App\Admin\Controllers\Product;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\ExcelOrder;
use App\Admin\Models\GoodsOrder;
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
            $content->header('未导出订单');
            $content->description('未导出订单');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(GoodsOrder::class, function (Grid $grid){
            $username = Admin::user()->username;
            $store =  WorkFlow::service('StoreService')
                ->with('admin_user',$username)
                ->run('getStoreInfoByAdminUser');
                
            if($store){
                $grid->model()
                ->where('store_id','')
                ->orderBy('create_time', 'desc');
            }else{
                $grid->model()
                ->orderBy('create_time', 'desc');
            }
            
            $todayEnd= date('Y-m-d 23:59:59', strtotime("-1 day"));// 2018 1 23 2400
            $todaystart = date("Y-m-d 00:00:00",strtotime("-1 day"));//2018 1 23 0000
            $grid->disableCreateButton();
            $grid->disableActions();
            $grid->model()->where('create_time', '<', $todayEnd);
            $grid->model()->where('create_time', '>', $todaystart);
            $grid->model()->where('export_status', '=', '20');
            $grid->model()->where('state', '=', '20');
            $grid->model()->where('goods_type', '=', '10');
            $grid->column('id','ID')->sortable();
            $grid->column('goods_id','商品编号')->sortable();
            $grid->column('goods.name','商品名称')->sortable();
            $grid->column('goods.supplier','供货商')->sortable();
            $grid->column('unit_price','单价')->sortable();
            $grid->column('total_price','总价')->sortable();
            $grid->column('promote_profit','推广分润')->sortable();
            $grid->column('number','数量')->sortable();
            $grid->column('address','收货地址')->sortable();
            $grid->column('consignee_name','收货人姓名')->sortable();
            $grid->column('consignee_mobile','收货人手机号')->sortable();
            $grid->column('update_time','下单时间')->sortable();
            $grid->column('user_id','用户编号')->sortable();
            $grid->column('user.user_name','用户名')->sortable();
            $grid->column('state','订单状态')
                ->display(function($state){
                    return config('product.state.'.$state);
                })->sortable();
            $grid->column('goods_type','商品类型')
                ->display(function($goods_type){
                    return config('product.goods_type.'.$goods_type);
                })->sortable();
            $grid->column('export_status','导出状态')
                ->display(function($export_status){
                    return config('product.export_status.'.$export_status);
                })->sortable();
            $grid->exporter(new ExcelOrder());
            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('address','收货地址');
                $filter->like('goods_id','商品编号');
            });

            $grid->paginate(15);
        });
    }
}