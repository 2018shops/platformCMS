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
use App\Modules\WorkFlow\WorkFlow;

class StoreDetailsController extends Controller{

    use ModelForm;
    /**
     * 状态 10 正常 20 关闭 30 热门  40 待审核  50 禁用
     */
    public function index()
    {
        $username = Admin::user()->username;
        $store =  WorkFlow::service('StoreService')
            ->with('admin_user',$username)
            ->run('getStoreInfoByAdminUser');
        return $this->show($store['id']);
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

    protected function detail()
    {
        return Admin::form(Store::class,function(Form $form){
            $form->tab('基本信息',function(Form $form) {
                $form->display('id','ID');
                $form->hidden('id','ID');
                $form->hidden('status','状态');
                $form->text('name','店铺名称');
                $form->text('tel','电话');
                // $form->display('top_img','店铺图片');
                // $form->display('top_img','店铺图片')->with(function ($src){
                //     return "<img src='{$src}'>";
                // });
                $form->image('top_img', '店铺图片');
                $form->text('store_desc','店铺描述');
                
                $form->display('status','店铺状态')->with(function ($status){
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
            $form->saving(function (Form $form) {
                
            });
            $form->saved(function (Form $form) {
            });
        });
    }
}