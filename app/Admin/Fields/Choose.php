<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4
 * Time: 16:03
 */

namespace App\Admin\Fields;

use Encore\Admin\Form\Field;

class Choose extends Field
{
    protected $url;
    protected $icon;
    protected $class;
    protected $id;
    protected $data;
    protected $view = 'admin.choose';


    public function render()
    {
        $url   = $this->url;
        $icon  = $this->icon;
        $class = $this->class;
        $label = $this->label;
        $id    = $this->id;
        $data  = ['0' => 'aaaa','1' => 'qqqqq'];
        return view($this->view, compact('url','icon','class','id','label','data'));
    }
}