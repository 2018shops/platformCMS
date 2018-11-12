<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/9/10
 * Time: 10:02
 */

namespace App\Admin\Fields;


use Encore\Admin\Form\Field;

class DemoButton extends Field
{
    protected $url;
    protected $icon;
    protected $class;
    protected $id;
    protected $view = 'admin.tool.demo';
    protected $text;

    function __construct($url,$icon,$text,$id,$class = 'btn btn-success pull-left')
    {
        $this->url  = $url;
        $this->icon = $icon;
        $this->text = $text;
        $this->id   = $id;
        $this->class = $class;
    }

    public function render()
    {
        $url  = $this->url;
        $icon  = $this->icon;
        $text = $this->text;
        $class = $this->class;
        $id = $this->id;
        return view($this->view, compact('url','icon','text','id','class'));
    }
}