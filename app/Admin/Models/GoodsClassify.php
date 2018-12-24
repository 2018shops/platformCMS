<?php

namespace App\Admin\Models;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GoodsClassify extends Model {
	use ModelTree, AdminBuilder;

	protected $table = "goods_classify";
	protected $primaryKey = 'id';
	protected $keyType = 'int';
	public $timestamps = true;
	const CREATED_AT = 'create_time';
	const UPDATED_AT = 'update_time';

	protected $fillable = ['id', 'name', 'pid', 'sort'];

	public function __construct(array $attributes = []) {
		parent::__construct($attributes);

		$this->setParentColumn('pid');
		$this->setOrderColumn('sort');
		$this->setTitleColumn('name');
	}

	public static function selectOptions() {
		$options = DB::table('goods_classify')->select('id', 'name as text')
			->where('pid', '=', 0)
			->get();

		foreach ($options as $option) {
			$seleceOption[$option->id] = $option->text;
		}

		return $seleceOption;
	}

	public static function getGoodsClassifyList($id) {
		$seleceOption = [];
		if ($id) {
			$options = DB::table('goods_classify')->select('id', 'name')->find($id);
			$seleceOption[$options->id] = $options->name;
		} else {
			$options = DB::table('goods_classify')->select('id', 'name as text')
				->where('pid', '!=', 0)
				->get();

			foreach ($options as $option) {
				$seleceOption[$option->id] = $option->text;
			}
		}
		return $seleceOption;
	}
}