<?php
/**
 * Created by PhpStorm.
 * User: wqb
 * Date: 2018/5/14
 * Time: 18:43
 */

namespace App\Admin\Controllers\Team ;


use App\Admin\Contracts\Grid;
use App\Admin\Models\CommUser;
use Encore\Admin\Layout\Content;
use App\Admin\Models\TeamRelation;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Admin\Contracts\Facades\Admin;
use App\Admin\Repository\CommUserRepository;

class TeamController extends Controller {
    
    public $userPepo;

    /**
     * 注入Repository
     */
    public function  __construct(CommUserRepository $Repository){
        $this->userPepo = $Repository;
    }

    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('用户推荐关系');
            $content->description('用户推荐关系列表');

            $content->body($this->grid());
        });
    }

    public function grid(){
        $userEntity =  $this->userPepo->getEntity("1090386295806630400");
        Log::info(json_encode($userEntity));
        return Admin::grid(TeamRelation::class,function(Grid $grid){
            $grid->disableCreateButton();
            $grid->disableExport();
            $grid->disableRowSelector();

            $grid->model()->orderBy('create_time', 'desc');

            $grid->column('id','ID')->sortable();
            $grid->column('user_id','用户ID')->sortable();
            $grid->column('user.user_name','用户名')->sortable();
            $grid->column('user.user_tariff_code','用户等级')->display(function($level){
                return config('const_user.'.$level.'.msg');
            });
            $grid->column('user.status','用户状态')->display(function($status){
                return config('const_user.USER_STATUS.'.$status);
            });
            $grid->column('parent1','直推')->display(function($id){
                $info = CommUser::find($id);
                return "<span title='{$info['user_name']}' class=''>{$id}<br/>{$info['user_name']}(".
                config('const_user.'.$info['user_tariff_code'].'.msg').")</span>";
            });
            $grid->column('parent2','间推')->display(function($id){
                $info = CommUser::find($id);
                return "<span title='{$info['user_name']}' class=''>{$id}<br/>{$info['user_name']}(".
                config('const_user.'.$info['user_tariff_code'].'.msg').")</span>";
            });
            $grid->column('parent3','顶推')->display(function($id){
                $info = CommUser::find($id);
                return "<span title='{$info['user_name']}' class=''>{$id}<br/>{$info['user_name']}(".
                config('const_user.'.$info['user_tariff_code'].'.msg').")</span>";
            });
            $grid->column('create_time','创建时间')->sortable();

            $grid->filter(function ($filter) {
                // 设置created_at字段的范围查询
                $filter->like('user_id','用户ID');
                $filter->like('user_name','用户名');
                $filter->like('parent1','直推');
                $filter->like('parent2','间推');
                $filter->like('parent3','顶推');
                $filter->like('team_user_level','团队推荐关系');
                $filter->between('create_time', '创建时间')->datetime();
                $filter->between('update_time', '更新时间')->datetime();
            });
            $grid->actions(function ($actions) {
                // 添加操作
                // 当前行的数据数组
                $actions->row;
                //获取当前行主键值
                $actions->getKey();
                //$actions->prepend();
                $actions->prepend('<a href=""><i class="fa fa-mouse-pointer"  title="审核"></i></a>');
                $actions->disableDelete();
                $actions->disableEdit();
            });




            $grid->paginate(15);
        });
    }
}