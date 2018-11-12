<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/7
 * Time: 14:05
 */

namespace App\Admin\Controllers\Team;


use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\InviteCode;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class InviteCodeController extends Controller
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

//    public function create()
//    {
//        return Admin::content(function(Content $content){
//            $content->body($this->form());
//        });
//    }

    public function form()
    {
        return Admin::form(InviteCode::class,function (Form $form){

        });
    }
    public function grid()
    {
        return Admin::grid(InviteCode::class,function(Grid $grid){
            $grid->model()->where('type', '10');
            $grid->model()->orderBy('create_time', 'desc');
            $grid->column('code','邀请码');
            $grid->column('amount','邀请码价格（元）');
            $grid->column('level_name','邀请码等级')
                ->display(function($level_name){
                    return config('exam.Invite.level_name.'.$level_name);
                });

            $grid->column('old_user_id','原始持有人ID');
            $grid->column('invite.user_name','原始持有人姓名');
            $grid->column('state','邀请码使用状态')
                ->display(function($status){
                    return config('exam.Invite.detailType.'.$status);
                });
            $grid->column('user_id','邀请码现所属用户ID');
            $grid->column('new.user_name','邀请码现所属用户');
            $grid->column('change_state','邀请码变更状态')
                ->display(function($status){
                    return config('exam.Invite.changeState.'.$status);
                });
            $grid->column('use_user_id','邀请码使用人ID');
            $grid->column('use.user_name','邀请码使用人姓名');
            $grid->column('change_time','邀请码变更时间');
            $grid->column('use_time','邀请码使用时间');
            $grid->column('update_time','更新时间')->sortable();

            //筛选
            $grid->filter(function ($filter){
                $filter->like('code','邀请码');
                $filter->like('state','邀请码状态')->select(config('exam.Invite.detailType'));
                $filter->like('level_name','邀请码等级')->select(config('exam.Invite.level_name'));
                $filter->like('change_state','邀请码变更状态')->select(config('exam.Invite.changeState'));
                $filter->like('user_id','邀请码现所属用户ID');
                $filter->like('new.user_name','邀请码现所属用户姓名');
                $filter->like('old_user_id','原始持有人ID');
                $filter->like('invite.user_name','原始持有人姓名');
                $filter->like('use_user_id','邀请码使用人ID');
                $filter->like('use.user_name','邀请码使用人姓名');
            });

            //禁止创建及修改
            $grid->disableCreateButton();
            $grid->disableActions();

            $grid->paginate(15);
        });
    }



}