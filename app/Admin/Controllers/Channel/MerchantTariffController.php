<?php

namespace App\Admin\Controllers\Channel;



use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\AcctUserTariffRate;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class MerchantTariffController extends Controller{

    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){

            $content->header('商家资费');
            $content->description('商家资费');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增商家资费');
            $content->description('新增商家资费');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑商家资费');
            $content->description('编辑商家资费');
            $content->body($this->form()->edit($id));
        });
    }
    public function form()
    {
        return Admin::form(AcctUserTariffRate::class, function (Form $form){
            $form->display('id', 'ID');


            $form->text('user_tariff_code','商户资费编号');
            $form->text('business_code','业务编号');
            $form->text('business_name','业务名称');
            $form->text('pay_way_id','支付方式');
            $form->text('pay_select','支付方式选择');
            $form->text('rate','费率');
            $form->text('max_rate','附加费');
            $form->text('base_rate','基准费率');
            $form->text('base_max_rate','基准附加费');
            $form->text('remarks','备注');



            $form->hidden('create_by')
                ->default(Admin::user()->getAuthIdentifier());
            $form->hidden('update_by')
                ->default(Admin::user()->getAuthIdentifier());

            $states = [
                'on' => ['value' => 1, 'text' => '启用', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],

            ];
            $form->switch('status', '状态')->states($states);

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });
            $form->saved(function (Form $form) {
            });
        });
    }
    public function grid()
    {
        return Admin::grid(AcctUserTariffRate::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('user_tariff_code','商户资费编号')->sortable();
            $grid->column('business_code','业务编号')->sortable();
            $grid->column('business_name','业务名称')->sortable();
            $grid->column('pay_way_id','支付方式')->sortable();
            $grid->column('pay_select','支付方式选择')->sortable();
            $grid->column('rate','费率')->sortable();
            $grid->column('max_rate','附加费')->sortable();
            $grid->column('base_rate','基准费率')->sortable();
            $grid->column('base_max_rate','基准附加费')->sortable();
            $grid->column('remarks','备注')->sortable();
            $grid->column('status','状态')->sortable();
            $grid->column('update_by','更新者');
            $grid->column('update_time','更新时间')->sortable();
            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('business_code','业务编号');
                $filter->like('business_name','业务名称');
            });

        });
    }
}