<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/28
 * Time: 18:01
 */

namespace App\Admin\Controllers\Trans;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\CoffeeConsumeOrder;
use App\Admin\Models\ProductOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Content;
use App\Admin\Contracts\Grid;

class ProductOrderController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('咖啡消费订单');
            $content->description('咖啡消费订单');
            $content->body($this->grid());
        });
    }

    public function grid()
    {
        return Admin::grid(ProductOrder::class,function(Grid $grid) {
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id','明细订单ID');
            $grid->column('product_id','产品编号');
            $grid->column('bean_price','价格(豆)')->sortable();
            $grid->column('rmb_price','价格(元)');
            $grid->column('user_id','用户编号');
//            $grid->column('user.user_name','用户姓名');
            $grid->column('cafe_id','店主编号');
            $grid->column('status','交易状态')
                ->display(function ($status){
                    return config('const_trans.product_status.'.$status);
                });
            $grid->column('fd','socket编号');
            $grid->column('update_time','更新时间')->sortable();
            // 筛选
            $grid->filter(function ($filter) {
                $filter->like('id','明细流水ID');
                $filter->like('product_id','产品编号');
//                $filter->like('user.user_name','用户名');
                $filter->equal('status','交易状态')->select(config('const_trans.product_status'));
            });
            $grid->disableCreateButton();
            $grid->disableActions();
        });
    }
}