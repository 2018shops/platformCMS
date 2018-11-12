<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/4/2
 * Time: 15:02
 */

namespace App\Admin\Controllers\Record;

use App\Admin\Models\CommPushRecord;
use App\Admin\Models\CommUser;
use App\Modules\WorkFlow\WorkFlow;
use Encore\Admin\Form;
use App\Admin\Contracts\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Admin\Contracts\Facades\Admin;
use Encore\Admin\Controllers\ModelForm;

class PushRecordController extends Controller {

    use ModelForm;

    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('推送记录');
            $content->description('推送记录');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content){
            $content->header('新建推送');
            $content->description('新建推送');
            $content->body($this->form());
        });
    }
    /**
     * 表格列表
     */
    public function grid()
    {
        Log::info("log ....");
        return Admin::grid(CommPushRecord::class,function(Grid $grid){
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('id',"ID");
            $grid->column('process_id_from','编号FROM')->sortable();
            $grid->column('process_id_to','编号TO')->sortable();
            $grid->column('business_code','业务模版')->sortable();
            $grid->column('title','标题');
            $grid->column('content','内容')
                ->display(function($limit) {
                    return str_limit($limit, 18, '...');
                });
            $grid->actions(function ($actions) {
                $actions->prepend("<a href='/admin/record/pushRecord/{$this->getKey()}'><i class='fa fa-eye'>查看</i></a>");
            });
            $grid->column('type','APP类型')->sortable();
            $grid->column('status','状态')->sortable();
            $grid->column('create_time','创建时间')->sortable();
            $grid->filter(function($filter){
                $filter->like('id','ID');
                $filter->like('process_id_frome','编号FROM');
                $filter->like('business_code','业务模版');
                $filter->like('title','标题');
                $filter->like('content','内容');
                $filter->like('type','APP类型');
                $filter->like('client_id','客户端ID');
            });
//            $grid->disableCreateButton();
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('推送记录');
            $content->description('推送记录');
            $content->body($this->detail()->view($id));
        });
    }

    private function detail()
    {
        return Admin::form(CommPushRecord::class,function(Form $form){
            $form->display('id','ID');
            $form->display('content','内容');

            $form->disableSubmit();//隐藏保存按钮
            $form->disableReset(); //去掉重置按钮

        });
    }

    public function form()
    {
        return Admin::form(CommPushRecord::class,function(Form $form){
            $form->display('id','Id');
            $form->hidden('status','Id')->default('1');
            $form->select('process_id_to','用户编号')
                ->options(function($name){
                    $store = CommUser::find($name);
                    if($store) return [$store->id => $store->user_name];
                })
                ->ajax('/admin/api/usersall')->rules('required');

//            $form->text('process_id_to','用户编号');
            $form->text('title','推送标题');
            $form->textarea('content','推送内容');

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });

            $form->saved(function(Form $form){
                WorkFlow::service('JpushService')
                    ->with('user_id',$form->process_id_to)
                    ->with('title',$form->title)
                    ->with('msg',$form->content)
                    ->run('singlePushPms');
            });



        });
    }

}