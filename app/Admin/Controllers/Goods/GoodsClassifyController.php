<?php
namespace App\Admin\Controllers\Goods;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Models\GoodsClassify;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

class GoodsClassifyController extends Controller {
	use ModelForm;

	public function index() {
		return Admin::content(function (Content $content) {
			$content->header('商品分类');
			$content->description('商品分类');
			$content->body(GoodsClassify::tree());
		});
	}
	public function create() {
		return Admin::content(function (Content $content) {
			$content->header('新增商品分类');
			$content->description('新增商品分类');
			$content->body($this->form());
		});
	}
	public function edit($id) {
		return Admin::content(function (Content $content) use ($id) {
			$content->header('编辑商品分类');
			$content->description('编辑商品分类');
			$content->body($this->form()->edit($id));
		});
	}

	public function form() {
		return Admin::form(GoodsClassify::class, function (Form $form) {
			$form->hidden('id');

			$form->select('pid', '商品分类')
				->options(function ($id) {
					return GoodsClassify::selectOptions();
				});

			$form->text('name', '分类名称');
			$form->text('sort', '排序');
			// $form->text('status', '状态');
			$form->image('img', '图片');

			$form->saving(function (Form $form) {

			});
		});
	}

}