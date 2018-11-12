<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/13
 * Time: 10:08
 */

namespace App\Admin\Controllers\Team;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\InviteCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use function foo\func;

class ExternalCodeController extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function(Content $content){
            $content->header('邀请码明细');
            $content->description('邀请码明细');
            $content->body($this->grid());
        });
    }

    public function create()
    {
        return Admin::content(function(Content $content){
            $content->header('新增邀请码列表');
            $content->description('新增邀请码列表');
            $content->body($this->form());
        });
    }

    public function form()
    {
        return Admin::form(InviteCode::class,function(Form $form){
            $form->display('id','ID');

            $form->text('code','邀请码');
            $form->text('type','类型');
            $form->text('level_name','邀请码等级');
            $form->hidden('create_by')
                ->default(Admin::user()->getAuthIdentifier());
            $form->hidden('update_by')
                ->default(Admin::user()->getAuthIdentifier());

            $form->saving(function (Form $form){
                if(!$form->id){
                    $form->id = ID();
                }
            });
            $form->saved(function(Form $form){

            });
        });
    }

    public function grid()
    {
        return Admin::grid(InviteCode::class,function(Grid $grid){
            $grid->model()->where('type', '20');
            $grid->model()->orderBy('create_time','desc');
            $grid->column('id','邀请码ID');
            $grid->column('code','邀请码');
            $grid->column('amount','邀请码价格（元）');
            $grid->column('use.user_id','使用人ID');
            $grid->column('use.user_name','使用人姓名');
            $grid->column('state','使用状态')->display(function($state){
                return config('exam.Invite.detailType.'.$state);
            });
            $grid->column('level_name','邀请码等级')
                ->display(function($level_name){
                    return config('exam.Invite.external_level.'.$level_name);
                });
            $grid->column('update_time','更新时间')->sortable();

            //筛选
            $grid->filter(function($filter){
                $filter->like('code','邀请码');
                $filter->like('use.user_name','邀请码使用人姓名');
                $filter->like('use_user_id','邀请码使用人ID');
                $filter->like('state','邀请码状态')->select(config('exam.Invite.detailType'));
                $filter->like('level_name','邀请码等级')->select(config('exam.Invite.external_level'));
            });

            //禁止创建及修改
            $grid->disableActions();
//            $grid->disableCreateButton();

            $grid->paginate(15);
        });




    }
}