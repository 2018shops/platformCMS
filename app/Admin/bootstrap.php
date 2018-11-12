<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Admin\Contracts\Admin;
use App\Admin\Fields\TotalField;
use App\Admin\Fields\Ueditor;
use App\Admin\Fields\Choose;
use Encore\Admin\Form;
use App\Admin\Fields\UpRecommend;
use App\Admin\Fields\ThreeLevelRecommend;
Encore\Admin\Form::forget(['map']);//'editor' 开启富文本编辑器


//表单合计组件
Form::extend('total',TotalField::class);
Admin::js('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js');
//Admin::js('/vendor/chartjs/dist/Chart.min.js');

//富文本编辑
Form::extend('editor',Ueditor::class);
Form::extend('choose',Choose::class);

//获取全部上级
Form::extend('uprecommend',UpRecommend::class);
//获取三级
Form::extend('three_uprecommend',ThreeLevelRecommend::class);

