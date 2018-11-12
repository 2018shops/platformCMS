<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/16
 * Time: 15:58
 */
namespace App\Admin\Controllers\Image;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\WechatShare;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class WechatShareController extends Controller {

	use ModelForm;

	public function index() {
		return Admin::content(function (Content $content) {
			$content->header('分享语管理');
			$content->description('分享语管理');
			$content->body($this->grid());
		});
	}

	public function create() {
		return Admin::content(function (Content $content) {
			$content->header('新建分享语');
			$content->description('新建分享语');
			$content->body($this->form());
		});
	}
	public function edit($id) {
		return Admin::content(function (Content $content) use ($id) {

			$content->header('编辑分享语');
			$content->description('分享语');
			$content->body($this->form()->edit($id));
		});
	}
	public function grid() {
		return Admin::grid(WechatShare::class, function (Grid $grid) {
			$grid->model()->orderBy('update_time', 'desc');
			$grid->column('id', 'Id');
			$grid->column('sort', '排序');
			$grid->column('statistics', '统计');
			$grid->column('views', '观看次数');
			$grid->column('title', '标题');
			$grid->column('content', '内容');
			$grid->column('share_little_url', '小图地址');
			$grid->column('share_large_url', '大图地址');

			// $grid->column('kind_of','分享类型')->display(function($type){
			//     return config('meeting.kind_of.'.$type);
			// })->sortable();

			$grid->column('status', '状态')->display(function ($type) {
				return config('meeting.banner_status.' . $type);
			})->sortable();

			$grid->column('update_time', '更新时间');
		});
	}

	public function form() {
		return Admin::form(WechatShare::class, function (Form $form) {
			$form->display('id', 'Id');
			$form->hidden('id', 'Id');
			$form->display('kind_of', '10');
			$form->text('title', '标题');
			$form->text('content', '内容');
			$form->image('share_little_url', '小图地址');
			$form->image('share_large_url', '大图地址');

			$form->image('banner', '图片地址');

			$form->select('status', '状态')->options(
				config('meeting.banner_status')
			)->rules('required');

			$form->saving(function (Form $form) {
				if (!$form->id) {
					$form->id = ID();
				}
			});

			$form->saved(function (Form $form) {
			});
		});
	}
}