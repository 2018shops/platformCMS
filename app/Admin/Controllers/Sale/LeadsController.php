<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/4/2
 * Time: 15:02
 */

namespace App\Admin\Controllers\Sale;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Models\Leads;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Content;

class LeadsController extends Controller {

    use ModelForm;

    public function index()
    {

        return Admin::content(function (Content $content){
            $content->header("这里是form头");
            $content->description('这是描述...');
            $content->body($this->grid());
        });

    }

    public function grid()
    {
        return Admin::grid(Leads::class,function(Grid $grid){

            $grid->column('id','ID')->sortable();
            $grid->column('title','标题')->sortable();




        });
    }



}