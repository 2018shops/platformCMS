<?php

use App\Modules\WorkFlow\WorkFlow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use QL\QueryList;
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/15
 * Time: 14:29
 */
function SNO($mark){
    $no = 0;
    DB::beginTransaction();
    try{
        DB::table('sn')->where('mark',$mark)->lockForUpdate()->increment('no');
        $no = DB::table('sn')->where('mark',$mark)->first(['no'])->no;
    }catch (\Exception $ex){
        DB::rollback();
    }
    DB::commit();
    return $no;
}

function ID (){
    return app()->make(\App\Common\Helpers\IdWorker::class)->getId();
}

function R($path = null,$flag = true)
{

    if(app()->runningInConsole()){
        return null;
    }
    if($flag){
        $url = "http://" . $_SERVER['HTTP_HOST'] . "/image" . "/";
    }else{
        $url = "http://pms.melenet.com/";
    }

    if (is_array($path)) {
        $src = array();
        foreach ($path as $key => $val) {
            $src[$key] = $url . $val;
        }
        return $src;
    }

    return $url . $path;
}

//获取当前用户角色
function Role($userId)
{
    $re = DB::table('admin_role_users as t1')
        ->select('t2.slug')
        ->leftJoin('admin_roles as t2', function ($join){
            $join->on('t1.role_id', '=', 't2.id');
        })
        ->where('t1.user_id',$userId)
        ->first();
    return $re->slug;
}
//******************工作流相关   ||--------->

/**
 * 审批按钮
 */
function approvedBtn (){

    $url = Request::fullUrlWithQuery(['gender' => '_gender_']);
    return <<<EOT
    <button type="button" class="btn btn-success pull-left p-1" id = "approved"><i class='fa fa-eye'>审批</i>&nbsp;&nbsp;</button>
    <span class="pull-left p-1">&nbsp;&nbsp;</span>
    <script>
        $('#approved').unbind('click').click(function() {
            var url = "$url".replace('_gender_', $(this).val());
            var id = $("*[name='id']").val();
            var module = $("*[name='module']").val();
            var approv_state = $("*[name='approv_state']").val();
            var but_name = '';
           
            // alert(approv_state);return;
            switch(approv_state){
                case '' : but_name = '提交审批';
                    break;
                case '-1' : but_name = '审批通过';
                    break;
                case '2' : but_name = '重新提交审批';
                    break;
                default : but_name = '审批通过';
            }

            swal({
                title: "确认执行审批?", 
                text: "审批通过后,将进入下一环节！", 
                type: "warning",
                showCancelButton: true, 
                confirmButtonColor: "#DD6B55",
                confirmButtonText: but_name, 
                cancelButtonText: "取消审批",
                closeOnConfirm: false, 
                closeOnCancel: false	
              },
              function(isConfirm){ 
                if (isConfirm) { 
                    $.ajax({
                        method: 'get',
                        url: '/admin/workflow.approval',
                        data: {
                            m:module,
                            id:id,
                            state:approv_state
                        },
                        success: function (data) {
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    }); 
                } else { 
                  swal("取消！", "您取消了审批操作","error"); 
                } 
            });

        });
    </script>
EOT;

}

/**
 * 驳回按钮
 */
function rejectBtn (){

    $url = Request::fullUrlWithQuery(['gender' => '_gender_']);
    return <<<EOT
    <button type="button" class="btn btn-danger pull-left" id = "reject"><i class='fa fa-key'>驳回</i>&nbsp;&nbsp;</button>
    <span class="pull-left p-1">&nbsp;&nbsp;</span>
    <script>
        $('#reject').unbind('click').click(function() {
            // var url = "$url".replace('_gender_', $(this).val());
            var id = $("*[name='id']").val();
            var module = $("*[name='module']").val();
            
            swal({ 
                title: "确认执行驳回?", 
                text: "审批驳回后,将进入审批重新提交环节！", 
                type: "warning",
                showCancelButton: true, 
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确认驳回", 
                cancelButtonText: "取消驳回",
                closeOnConfirm: false, 
                closeOnCancel: false	
              },
              function(isConfirm){ 
                if (isConfirm) { 
                    $.ajax({
                        method: 'get',
                        url: '/admin/workflow.reject',
                        data: {
                            m:module,
                            id:id
                        },
                        success: function (data) {
                            console.info(data);
                            if (typeof data === 'object') {
                                if (data.code == '0000' || data.status) {
                                    swal(data.message, '', 'success');
                                } else {
                                    swal(data.message, '', 'error');
                                }
                                $.pjax.reload('#pjax-container');
                            }
                        }
                    }); 
                } else { 
                  swal("取消！", "您取消了驳回操作","error"); 
                } 
            });

        });
    </script>
EOT;

}

/**
 * 
 * 审批模块触发审批流
 * $id 模块主键 :: 1
 * $module 模块标识 ::customer
 * approv_state :  0：待审批， -1提交审批（发起），2审批驳回，3审批通过，4审批结束
 * */
function saveApproveStatus($id,$module){
    //插入表 erp_approv_record
    // 审批设置ID  -1；
    // 审批流程ID  -1；
    // 审批状态   0；
    return WorkFlow::service('Launch')->with('id',$id)->with('module',$module)->run();
}

/**
 * 获取审批历史记录
 * * $id 模块主键 :: 1
 * $module 模块标识 ::customer
 */
function getApproveHistory($id,$module){
    //查询表 erp_approv_record
    //Service.Reject.handle
    return WorkFlow::service('WorkFlowService')->with('id',$id)->with('module',$module)->run("getApproveHistory");

}

/**
 * 检查是否有编辑权限
 * 
 */
function checkApproveEdit($id,$module){
    //插入表 erp_approv_record
    // 审批设置ID  -1；
    // 审批流程ID  -1；
    // 审批状态   0；
    return WorkFlow::service('WorkFlowService')->with('id',$id)->with('module',$module)->run("checkApproveEdit");
}

/**
 * 检查是否有删除权限
 * 
 */
function checkApproveDestroy($id,$module){
    //插入表 erp_approv_record
    // 审批设置ID  -1；
    // 审批流程ID  -1；
    // 审批状态   0；
    return WorkFlow::service('WorkFlowService')->with('id',$id)->with('module',$module)->run("checkApproveDestroy");
}
/**
 * html转换
 */
if (!function_exists('makeJsContent')){
    function makeJsContent($html)
    {
        $rules = [
            'img' => ['img', 'src'],
            'img_w' => ['img', 'width'],
            'img_h' => ['img', 'height'],

        ];

        $data = QueryList::html($html)
            ->rules($rules)
            ->range('p')
            ->query()
            ->getData(function ($item) {
                if ($item['img']) {
                    return [
                        'name' => 'ViewImg',
                        'src' => $item['img'],
                        'height' => $item['img_h'],
                        'width' => $item['img_w']
                    ];
                }else {
                    return [
                    ];
                }
            });
        dd($data);
        return $data->all();
    }
}
//******************工作流相关  <---------||