<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4
 * Time: 13:40
 */

namespace App\Admin\Fields;
use App\Modules\WorkFlow\WorkFlow;
use Encore\Admin\Form\Field;

class UpRecommend extends Field
{
    protected $view = 'admin.team.bar';
    protected $groups;

    public function render()
    {
        $groups = WorkFlow::service('TeamService')
            ->with('user_id',$this->value)
            ->run('getSuperiorRecommendAll');
        //dd($groups);
        return view($this->view, compact('groups'));
    }
}