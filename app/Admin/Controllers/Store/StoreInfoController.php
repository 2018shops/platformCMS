<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16
 * Time: 15:58
 */
namespace App\Admin\Controllers\Store;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\Store;
use App\Admin\Models\TopLine;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use App\Admin\Fields\ExtendButton;

class StoreInfoController extends Controller{

    use ModelForm;
    /**
     * 状态 10 正常 20 关闭 30 热门  40 待审核  50 禁用
     */
    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('店铺全部信息');
            $content->description('店铺全部信息');
            $content->body($this->grid());
        });
    }

    /**
     * 显示详情
     */
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('店铺详情');
            $content->description('店铺详情');
            $content->body($this->detail()->view($id));
        });
    }

    public function grid()
    {
        return Admin::grid(Store::class,function(Grid $grid){
            $grid->disableCreateButton();
            $grid->disableExport();
            //province_id city_id distinct_id
            $grid->column('id','Id');
            $grid->column('name','店铺名称')->sortable()->display(function ($user_name) {
                return "<a href='/admin/store/storeinfo/{$this->getKey()}' class=''><b>$user_name</b></a>";
            });
            // $grid->column('name','店铺名称')->sortable();
            $grid->column('tel','电话')->sortable();
            $grid->column('top_img','店铺图片')->sortable();
            $grid->column('store_desc','店铺描述')->sortable();
            $grid->column('user_id','用户ID')->sortable();
            $grid->column('record','评分')->sortable();
            $grid->column('browse_volume','浏览量')->sortable();
            $grid->column('serv_record','服务评分')->sortable();
            $grid->column('cafe_record','店铺评分')->sortable();
            $grid->column('number_people','评级人数')->sortable();
            $grid->column('status','状态')->display(function($type){
                return config('store.status.'.$type);
            })->sortable();
            $grid->column('create_time','创建时间')->sortable();

            $grid->filter(function($filter){
                $filter->like('name','店铺名称');
                $filter->like('tel','店主电话');
            });
        });
    }

    protected function detail()
    {
        return Admin::form(Store::class,function(Form $form){
            $form->tab('基本信息',function(Form $form) {
                $form->display('id','ID');
                $form->hidden('id','ID');
                $form->display('name','店铺名称');
                $form->display('tel','电话');
                // $form->display('top_img','店铺图片');
                $form->display('top_img','店铺图片')->with(function ($src){
                    return "<img src='{$src}'>";
                });
                $form->display('store_desc','店铺描述');
                $form->display('user_id','用户ID');
                $form->display('status','用户ID');   
                $form->display('status','微信头像')->with(function ($status){
                    return config('store.status.'.$status);
                });
            });
            $form->tab('店铺评分',function(Form $form) {
                $form->display('record','评分');
                $form->display('browse_volume','浏览量');
                $form->display('serv_record','服务评分');
                $form->display('cafe_record','店铺评分');
                $form->display('number_people','评级人数');
            });

            $form->tools(function ($tools) {
                
                $tools->add('');
                $url = "/admin/workflow.goods_examine_pass";
                $icon = "fa fa-check";
                $text = "通过审核";
                $id = "examine_pass";
                $tools->add(new ExtendButton($url,$icon,$text,$id));

                $url = "/admin/workflow.goods_examine_pass";
                $icon = "fa fa-times";
                $text = "拒绝审核";
                $id = "examine_pass";
                $tools->add(new ExtendButton($url,$icon,$text,$id));

                $url = "/admin/workflow.goods_examine_pass";
                $icon = "fa fa-times";
                $text = "强制禁用";
                $id = "examine_pass";
                $tools->add(new ExtendButton($url,$icon,$text,$id));
            });
            // $form->tools(function (Form\Tools $tools) {
               
            // });
        });
    }
}