<?php
namespace App\Admin\Controllers\Goods;

use App\Admin\Contracts\Facades\Admin;
use App\Admin\Contracts\Grid;
use App\Admin\Fields\CustomerButton;
use App\Admin\Models\GoodsInfo;
use App\Admin\Models\GoodsClassify;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Form;
use App\Admin\Fields\ExcelExporter\ExportTaskRecord;
use Encore\Admin\Layout\Content;
use App\Admin\Fields\ExtendButton;
use App\Modules\WorkFlow\WorkFlow;


class GoodsInfoCon extends Controller
{
    use ModelForm;
    public function index()
    {
        return Admin::content(function (Content $content){
            $content->header('商品全部信息');
            $content->description('商品全部信息,商城首页新品推荐图690X285,商品详情轮播图750X530,产品详情长图750 ');
            $content->body($this->grid());
        });
    }
    public function create()
    {
        return Admin::content(function (Content $content){
            $content->header('新增商品信息');
            $content->description('新增商品信息,商城首页新品推荐图690X285,商品详情轮播图750X530,产品详情长图750 ');
            $content->body($this->form());
        });
    }
    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id) {
            $content->header('编辑商品信息');
            $content->description('编辑商品信息,商城首页新品推荐图690X285,商品详情轮播图750X530,产品详情长图750 ');
            $content->body($this->form()->edit($id));
        });
    }
    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('商品信息详细信息');
            $content->description('商品信息详细信息');
            $content->body($this->detail()->view($id));
        });
    }

    public function grid()
    {
        return Admin::grid(GoodsInfo::class,function(Grid $grid) {
            $grid->exporter(new ExportTaskRecord());
            //根据后台登陆账号获取,店铺ID
            $username = Admin::user()->username;
            $store =  WorkFlow::service('StoreService')
                ->with('admin_user',$username)
                ->run('getStoreInfoByAdminUser');

            if($store){
                $grid->model()
                    ->where('store_id',$store['id'])
                    ->orderBy('create_time', 'desc');
            }else{
                $grid->model()
                    ->orderBy('create_time', 'desc');
            }

            $grid->column('id','ID');
            //store.name
            $grid->column('store.name','店铺名称')->display(function($name){
                return empty($name) ? '自营' : $name;
            });
            $grid->column('name','名字')->sortable()->display(function ($user_name) {
                return "<a href='/admin/goods/info/{$this->getKey()}' class=''><b>$user_name</b></a>";
            });
            $grid->column('introduce','简介');
            $grid->column('original_price','原价（元）')->sortable();
            $grid->column('price','价格（元）')->sortable();

//            $grid->column('integral','积分')->sortable();

            $grid->column('goods_type','商品分类')->display(function($id){
                $ret = GoodsClassify::find($id);
                return $ret['name'];
            });

            $grid->column('goods_class','活动商品类')->display(function($key){
                $arr = [
                    '10'=>'普通商品',
                    // '20'=>'积分商品'
                ];
                return $arr[$key] ?? '';
            });

            /*
            $grid->column('from_way','来源方式')->display(function($key){
                $arr = [
                    '00'=>'自营',
                    '10'=>'拼多多',
                ];
                return $arr[$key];
            });
            */
            $grid->column('sales','销量')->sortable();
            $grid->column('see','浏览量')->sortable();
//            $grid->column('like','点赞/收藏')->sortable();
            /*
            $grid->column('province','省');
            $grid->column('city','市');
            */

            $grid->column('sort','商品排序')->sortable();

            $grid->column('status','状态')->display(function($key){
                $arr = config('product.goods_status');
                return $arr[$key];
            })->sortable();
           $grid->column('describe','审核简介')->sortable();

            $grid->column('create_time','创建时间')->sortable();
            $grid->column('update_time','修改时间')->sortable();


            // 筛选
            $grid->filter(function ($filter) {
                $filter->like('name','商品名');
                $filter->like('introduce','简介');
                $filter->equal('goods_type','商品类型')
                    ->select(
                        [
                            '10'=>'食品生鲜',
                            '20'=>'服装配饰',
                            '30'=>'文体保健',
                            '40'=>'家居日化',
                            '50'=>'母婴专区',
                            '60'=>'特色自营',
                        ]
                    );
                $filter->equal('goods_class','活动商品类')
                    ->select(
                        [
                            '10'=>'普通商品',
//                            '20'=>'积分商品',
                        ]
                    );
                $filter->equal('status','状态')
                    ->select(
                        ['00'=>'上架','10'=>'下架','20'=>'未开售']
                    );
                $filter->equal('highlight','热品推荐')
                    ->select(
                        ['00'=>'不推荐','10'=>'热品推荐']
                    );
                $filter->equal('from_way','来源方式')
                    ->select(
                        ['00'=>'自营','10'=>'拼多多']
                    );
            });
            $grid->actions(function ($actions) use ($store) {
                // 添加操作
                // 当前行的数据数组
                $actions->row;
                //获取当前行主键值
                $actions->getKey();
                //$actions->prepend();
                if(!$store){
                    $actions->disableDelete();
                    $actions->disableEdit();
                }               
            });

            $grid->tools(function ($tools) {
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });

        });
    }
    protected function form()
    {
        return Admin::form(GoodsInfo::class, function (Form $form) {
            
            $form->hidden('id','ID');
            $form->hidden('store_id','ID');
            $form->tab('商品信息',function(Form $form){
                $form->text('name','名字')->rules('required');
                $form->text('introduce','简介')->rules('required');
                $form->text('original_price','原价（元）');
                $form->text('price','价格（元）')->rules('required');
                // $form->text('cost','成本（元）')->rules('required');
                // $form->text('promote_profit','推广分润（元）');
                // $form->text('integral','积分');
            });
            $form->tab('商品设置',function(Form $form){
                // $form->select('goods_type','商品类型')
                //     ->options([
                //         '10'=>'食品生鲜',
                //         '20'=>'服装配饰',
                //         '30'=>'文体保健',
                //         '40'=>'家居日化',
                //         '50'=>'母婴专区',
                //         '60'=>'特色自营',
                //     ])->rules('required');

            // $form->select('goods_type','商品分类')
            //     ->options(function($name){
            //         $classify = GoodsClassify::find($name);
            //         if($classify) return [$classify->id => $classify->name];
            //     })
            //     ->ajax('/admin/api/getGoodsClassify')->rules('required');

            $form->select('goods_type','商品分类')
                ->options(function($id){
                    return GoodsClassify::getGoodsClassifyList($id);
                    // admin_base_path('/admin/api/getGoodsClassify');
                });

                // $form->select('goods_class','活动商品类')
                //     ->options([
                //         '10'=>'普通商品',
                //         '20'=>'积分商品',
                //     ])->rules('required');

                // $form->select('from_way','来源方式')
                //     ->options([
                //         '00'=>'自营',
                //         '10'=>'拼多多',
                //     ])->rules('required');
                // $form->text('url','外部商品链接');

                $form->text('sort','商品排序');

                $form->select('highlight','热品推荐')
                    ->options([
                        '00'=>'不推荐',
                        '10'=>'推荐'
                    ])->rules('required');
            });
            $form->tab('商品数据',function(Form $form){
                $form->text('freight','运费')->rules('required');
                // $form->text('sales','销量')->rules('required');
                // $form->text('see','浏览量');
                // $form->text('like','点赞/收藏');

                $form->text('supplier','供货商');

                $form->text('province','省');
                $form->text('city','市')->rules('required');
            });
            $form->tab('商品图片',function(Form $form){
                $form->image('img', '商品展示图');
                $form->image('img_list', '商品列表图');
                $form->image('img1','商品图1');
                $form->image('img2','商品图2');
                $form->image('img3','商品图3');
                $form->image('img4','商品图4');
                $form->image('img5','商品图5');
            });
            $form->tab('分享相关',function(Form $form){
                $form->text('title','分享标题')->rules('required');
                $form->text('content','分享内容')->rules('required');
                $form->image('logo','分享logo')->rules('required');
                $form->text('share_amount','分享量');
            });
            $form->tab('商品详情',function(Form $form){
                $form->editor('detail','产品详情');
                $form->text('params','产品参数');
            });


            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                    $username = Admin::user()->username;
                    $store =  WorkFlow::service('StoreService')
                        ->with('admin_user',$username)
                        ->run('getStoreInfoByAdminUser');
                    $form->store_id = $store['id'];
                }
                
            });
            $form->saved(function (Form $form) {
            });

        });
    }
    private function detail()
    {
        return Admin::form(GoodsInfo::class, function (Form $form) {
            $form->tab('使用激活码审核', function (Form $form) {

                $form->hidden('id','ID');

            $form->tab('商品信息',function(Form $form){
                $form->display('name','名字')->rules('required');
                $form->display('introduce','简介')->rules('required');
                $form->display('original_price','原价（元）');
                $form->display('price','价格（元）')->rules('required');
//                $form->display('cost','成本（元）')->rules('required');
//                $form->display('promote_profit','推广分润（元）');
//                $form->display('integral','积分');
                $form->display('store.name','店铺名称')->with(function($name){
                    return empty($name) ? '自营' : $name;                
                });
            });
            $form->tab('商品设置',function(Form $form){
                $form->select('goods_type','商品分类')
                    ->options(function($id){
                        return GoodsClassify::getGoodsClassifyList($id);
                    });

                $form->select('goods_class','活动商品类')
                    ->options([
                        '10'=>'普通商品',
//                        '20'=>'积分商品',
                    ])->rules('required');

//                $form->select('from_way','来源方式')
//                    ->options([
//                        '00'=>'自营',
////                        '10'=>'拼多多',
//                    ])->rules('required');
//                $form->display('url','外部商品链接');

                $form->display('sort','商品排序');

                $form->select('highlight','热品推荐')
                    ->options([
                        '00'=>'不推荐',
                        '10'=>'推荐'
                    ])->rules('required');
//                $form->select('status','状态')
//                    ->options([
//                        '00'=>'下架',
//                        '10'=>'上架',
//                        '20'=>'未开售',
//                    ])->rules('required');
            });
            $form->tab('商品数据',function(Form $form){
                $form->display('freight','运费')->rules('required');
//                $form->display('sales','销量')->rules('required');
//                $form->display('see','浏览量'); 
//                $form->display('like','点赞/收藏');

                $form->display('supplier','供货商');

                $form->display('province','省');
                $form->display('city','市')->rules('required');
            });
            $form->tab('商品图片',function(Form $form){
                $form->image('img', '商品展示图');
                $form->image('img_list', '商品列表图');
                $form->image('img1','商品图1');
                $form->image('img2','商品图2');
                $form->image('img3','商品图3');
                $form->image('img4','商品图4');
                $form->image('img5','商品图5');
            });
            $form->tab('分享相关',function(Form $form){
                $form->display('title','分享标题')->rules('required');
                $form->display('content','分享内容')->rules('required');
                $form->image('logo','分享logo')->rules('required');
                $form->display('share_amount','分享量');
            });
            $form->tab('商品详情',function(Form $form){
                $form->editor('detail','产品详情');
                $form->display('params','产品参数');
            });

            $form->saving(function (Form $form) {
                if(!$form->id){
                    $form->id = ID();
                }
            });
            });

            $form->tools(function (Form\Tools $tools) {
                $tools->add('');
                    $url = "/admin/workflow.goods_examine_pass";
                    $icon = "fa fa-check";
                    $text = "重新提交审核";
                    $id = "examine_pass";
                    $tools->add(new ExtendButton($url,$icon,$text,$id));
            });
            $form->disableSubmit();//隐藏保存按钮
            $form->disableReset(); //去掉重置按钮

        });
    }
}