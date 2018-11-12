<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/25
 * Time: 11:20
 */

namespace App\Admin\Controllers\Master;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\InsuranceOrder;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class InsuranceController extends Controller
{
    use ModelForm;

    public function index() {
        return Admin::content(function (Content $content) {
            $content->header('车险订单列表');
            $content->description('车险订单列表');
            $content->body($this->grid());
        });
    }

    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('车险订单修改');
            $content->description('车险订单修改');

            $content->body($this->form()->edit($id));
        });
    }

    public function grid()
    {
        return Admin::grid(InsuranceOrder::class, function (Grid $grid){
            $grid->disableCreateButton();
            $grid->model()->orderBy('create_time', 'desc');

            // $grid->column('id','ID')->sortable();
            $grid->column('order_id','订单ID')->sortable();
            $grid->column('tel','用户手机号')->sortable();
            $grid->column('plate_number','车牌号')->sortable();
            $grid->column('vehiden_number','车架号')->sortable();
            $grid->column('vehengine_type','发动机号')->sortable();
            $grid->column('policy_name','投保人姓名')->sortable();
            $grid->column('by_policy_name','被保人姓名')->sortable();
            $grid->column('biz_total_num','商业险单号')->sortable();
            $grid->column('biz_total_premium','商业险金额')->sortable();
            $grid->column('force_total_num','交强险单号')->sortable();
            $grid->column('force_total_premium','交强险金额')->sortable();
            $grid->column('tax_total_permium','车船税金额')->sortable();
            $grid->column('biz_bkge_amount','商业险返佣')->sortable();
            $grid->column('force_bkge_amount','交强险返佣')->sortable();
            $grid->column('discount_amount','优惠金额')->sortable();
            $grid->column('biz_pay_time','商业险有效期')->sortable();
            $grid->column('force_pay_time','交强险有效期')->sortable();
            $grid->column('order_status','订单状态')->sortable();
            $grid->column('courier_number','快递单号')->sortable();
            $grid->column('user_id','用户ID')->sortable();
            $grid->column('estimate_amount','总返佣金额')->sortable();
            $grid->column('company_name','投保公司名称')->sortable();
            $grid->column('update_time','更新时间')->sortable();

            // filter($callback)方法用来设置表格的简单搜索框
            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('order_id','订单ID');
                $filter->like('tel','用户手机号');
                $filter->like('tplate_numberel','车牌号');
                $filter->like('vehiden_number','车架号');
                $filter->like('user_id','用户ID');
                $filter->between('update_time', '更新时间')->datetime();
            });

            $grid->paginate(15);
        });
    }

    protected function form()
    {
        return Admin::form(InsuranceOrder::class, function (Form $form) {
            $form->hidden('id');
            $form->text('id','ID');
            $form->text('order_id','订单ID');
            $form->text('tel','用户手机号');
            $form->text('plate_number','车牌号');
            $form->text('vehiden_number','车架号');
            $form->text('vehengine_type','发动机号');
            $form->text('policy_name','投保人姓名');
            $form->text('by_policy_name','被保人姓名');
            $form->text('biz_total_num','商业险单号');
            $form->text('biz_total_premium','商业险金额');
            $form->text('force_total_num','交强险单号');
            $form->text('force_total_premium','交强险金额');
            $form->text('tax_total_permium','车船税金额');
            $form->text('biz_bkge_amount','商业险返佣');
            $form->text('force_bkge_amount','交强险返佣');
            $form->text('discount_amount','优惠金额');
            $form->text('biz_pay_time','商业险有效期');
            $form->text('force_pay_time','交强险有效期');
            $form->text('order_status','订单状态');
            $form->text('courier_number','快递单号');
            $form->text('user_id','用户ID');
            $form->text('estimate_amount','总返佣金额');
            $form->text('company_name','投保公司名称');
            $form->text('update_time','更新时间');

        });
    }
}