<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/4
 * Time: 16:03
 */

namespace App\Admin\Fields;

use Encore\Admin\Form\Field;

class Ueditor extends Field
{
    public static $js = [
        '/packages/ueditor/ueditor.config.js',
        '/packages/ueditor/ueditor.all.min.js',
        '/packages/ueditor/ueditor.parse.min.js',
    ];

    protected $view = 'admin.ueditor';

    public function render()
    {
        $this->script = <<<EOT
        UE.delEditor('{$this->id}');
             var  ue = UE.getEditor('{$this->id}');
EOT;
        return parent::render();
    }
}