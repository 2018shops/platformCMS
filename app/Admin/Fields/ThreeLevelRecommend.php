<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/18
 * Time: 16:07
 */

namespace App\Admin\Fields;

use App\Modules\WorkFlow\WorkFlow;
use Encore\Admin\Form\Field;

class ThreeLevelRecommend extends Field
{
    protected $view = 'admin.team.bar';
    protected $groups;

    public function render()
    {
        $groups = WorkFlow::service('TeamService')
            ->with('user_id',$this->value)
            ->run('getThreeLevelRecommend');
        return view($this->view, compact('groups'));
    }
}