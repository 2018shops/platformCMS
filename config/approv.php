<?php
/**
 * Created by PhpStorm.
 * User: wangjh
 * Date: 2018/3/15
 * Time: 11:21
 */
return [
        'opening_state' =>[
            '01' => '激活',
            '02' => '不激活',
    ],
    'state' =>[
        '01' => '开启',
        '02' => '未开始',
    ],
    //审批状态
    'approv_state' => [
        '0'  => '待审批',
        '-1' => '触发审批流',
        '2'  => '审批驳回',
        '3'  => '审批通过,继续下一步',
        '4'  => '审批结束,通过',
        '5'  => '审批中'
    ],

    'status' => [
        'WAIT_APPROV'   => ['code' => '0','msg' => '待审批'],
        'SUB_APPROV'    => ['code' => '-1','msg' => '触发审批流'],
        'REJECT_APPROV' => ['code' => '2','msg' => '审批驳回'],
        'PASS_APPROV'   => ['code' => '3','msg' => '审批通过,继续下一步'],
        'END_APPROV'    => ['code' => '4','msg' => '审批结束,通过'],
        'PRO_APPROV'    => ['code' => '5','msg' => '审批中'],
    ]


];