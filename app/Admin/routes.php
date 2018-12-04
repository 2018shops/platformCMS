<?php

use App\Admin\Contracts\Facades\Admin;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    //    $router->get('/', 'Team\\UserController@index');
    $router->get('/', 'Home\\HomeController@index');

    $router->get('get_chart_data', 'Home\\HomeController@GetUserData');
    //测试
    $router->get('sale/customer/1/show', 'Home\\HomeController@GetUserData');
    $router->resources([
        'test/test' => 'Test\\TestController',
    ]);
    // sendMail
    $router->resources([
        'test/send' => 'Test\\MailController',
    ]);

    //用户管理模块
    $router->resources([
        'user/users' => 'Team\\UserController',
        'user/relation' => 'Team\\TeamController',
        'user/realname' => 'Team\\RealNameController',
        //外部使用的邀请码
        'user/external_code' => 'Team\\ExternalCodeController',
        // 邀请码详情
        'user/invite_code' => 'Team\\InviteCodeController',
        //邀请码审核
        'user/invite_code_examine' => 'Team\\InviteCodeExamineController',
    ]);
    //ERP -------------------------------------------

    //采购管理
    $router->resources([
        'buy/supplier'   =>'Buy\\SupplierContoller',
        'buy/product' =>'Buy\\ProductController',
        'buy/product_factory' =>'Buy\\ProductFactoryController',
        'buy/buy_order' =>'Buy\\BuyOrderController',


    ]);
    //销售管理
    $router->resources([
        'sale/customer'    =>'Sale\\CustomerController',
        'sale/userupgrade' =>'Team\\UserController',
        'sale/leads'       =>'Sale\\LeadsController',
    ]);

    $router->resources([
        'finance/balance' => 'Finance\\FinanceController',
        'finance/userBalance' => 'Finance\\UserFinanceController',
        'finance/book' => 'Finance\\BookingController',
        'finance/userbook' => 'Finance\\UserBookingController',
        'finance/templet' => 'Finance\\AcctTempletController',
        'finance/policy' => 'Finance\\AcctPolicyController',

    ]);

    //图片管理
    $router->resources([
        'img/banner' => 'Image\\ImgBannerController',
        'img/imghome' => 'Image\\ImgHomeController',
        'img/wechatshare' => 'Image\\WechatShareController',
    ]);


    //审批设置
    $router->resources([
        'approv/setting' => 'Approv\\ApprovSettingController',
        //审批流程
        'approv/process' => 'Approv\\ApprovProcessController',
        //审批记录
        'approv/record' => 'Approv\\ApprovRecordController',
        //待我审批
        'approv/toapprov' =>'Approv\\ToApprovController',
        //我审批的
        'approv/myapprov' => 'Approv\\MyApprovController',
        //我发起的
        'approv/myfire' => 'Approv\\MyFireController',

    ]);

    //导出订单
    $router->resources([
        'product/order' => 'Product\\GoodsOrderController',
    ]);
    //==========================================================================
    //-------头条模块--------
    //用车
    $router->resources([
        'top/top' => 'Top\\TopController',
    ]);
    // =================================商品模块==========================================
    $router->resources([
        'goods/info' => 'Goods\\GoodsInfoCon',// 商品信息
        'goodsAdited/info' => 'Goods\\GoodsInfoExamineCon',// 商品待审核信息  
        'goodsorder/info' => 'Goods\\GoodsOrderController',// 商品订单信息     
    ]);

    // =========================================================================

    // -------交易模块-------
    // 汇总流水
    $router->resources([
        'trans/summary' => 'Trans\\SummaryController',
    ]);
    // 明细流水
    $router->resources([
        'trans/detail' => 'Trans\\DetailController',
    ]);
    // 提现流水
    $router->resources([
        'trans/withdrawals' => 'Trans\\WithdrawalsController',
    ]);
    //代付流水
    $router->resources([
        'trans/wait' => 'Trans\\WaitWithdrawalController',
    ]);
    // 商品支付流水
    $router->resources([
        'trans/goodspay' => 'Trans\\GoodsPayOrderController',
    ]);

    // 微信流水
    $router->resources([
        'trans/weChat' => 'Trans\\WeChatController',
    ]);
    // 红包信息
    $router->resources([
        'trans/present' => 'Trans\\PresentController',
    ]);
    //店铺
    $router->resources([
        'store/storeinfo' => 'Store\\StoreInfoController',
    ]);
    


    // =================================资费通道模块================================


    $router->resources([
        // 资费产品
        'channel/tariffProduct' => 'Channel\\TariffProductController',
        // 商家资费
        'channel/merchantTariff' => 'Channel\\MerchantTariffController',
        // 合伙人分润
        'channel/partnerProfit' => 'Channel\\PartnerProfitController',
        // 代理分润
        'channel/agentProfit' => 'Channel\\AgentProfitController',
        // 用户分润
        'channel/userProfit' => 'Channel\\UserProfitController',
        // 用户等级
        'channel/userLevel' => 'Channel\\UserLevelController',
        // 通道列表
        'channel/channelList' => 'Channel\\ChannelListController',
        // 通道商户
        'channel/channelMerchant' => 'Channel\\ChannelMerchantController',
        // 通道资费
        'channel/channelTariff' => 'Channel\\ChannelTariffController',
    ]);
    // ====================================统计记录============================

    // 分享统计
    $router->resources([
        // 分享统计
        'record/shareControl' => 'Record\\ShareControlController',
        // 定位统计
        'record/mapLocation' => 'Record\\MapLocationController',
        // 短信记录
        'record/smsRecord' => 'Record\\SmsRecordController',
        // 推送记录
        'record/pushRecord' => 'Record\\PushRecordController',
        // 操作日志
        'record/operationLog' => 'Record\\OperationLogController',

    ]);

    //================================商城模块================================

    //产品信息
    $router->resources([
        'shop/info' => 'Shop\\CarInfoController',
        'shop/price' => 'Shop\\PriceController',
        'shop/product' => 'Shop\\ProductController',
        'shop/banner' => 'Shop\\ImgBannerController',
        'shop/share' => 'Shop\\ActShareController',
    ]);

    //参数配置
    $router->resources([
        //数据词典
        'master/data_dic' => 'Master\\DataDicController',
        //功能简介
        'master/brief_list' => 'Master\\UpdateBriefController',
        //消息模块 短信记录
        'master/sms_list' => 'Master\\SMSController',
        //消息模块 推送记录
        'master/push_list' => 'Master\\MsgController',
        //消息模块 消息模版
        'master/push_templet' => 'Master\\MsgTempletController',
        //红包管理
        'master/packet_list' => 'Master\\RedPacketController',
        //活动管理
        'master/activity_list' => 'Master\\ActivityController',
        //帮助中心
        'master/help_list' => 'Master\\HelpController',
        //银行库
        'master/bank_list' => 'Master\\BankController',
        //救援保险
        'master/insurance_list' => 'Master\\InsuranceController'
    ]);

    // ===============================END=====================================

    //ajax联选等接口部分
    $router->get('/api/province','Api\\City@getProvince');
    $router->get('/api/city','Api\\City@getCity');

    $router->get('/api/users','Api\\User@getUsers');
    $router->get('/api/usersall','Api\\CommUserinfo@getUserByUserid');
    $router->get('/api/backUsers','Api\\User@backUsers');
    $router->get('/api/getId','Api\\User@getId');

    $router->get('/api/stores','Api\\Store@getStores');
    $router->get('/api/stocks','Api\\Store@getStocks');

    $router->get('/api/product','Api\\Product@getProduct');
    $router->get('/api/factory','Api\\Product@getFactory');
    $router->get('/api/factory_brand','Api\\Product@getBrand');
    $router->get('/api/supplier','Api\\Product@getSupplier');


    $router->get('/api/model','Api\\Model@getModel');
    $router->get('/api/cafe','Api\\Model@getCafe');
    $router->get('/api/cafeall','Api\\Model@getCafeAll');


    //审批详情
    $router->get('/api/approv','Api\\Approv@approvDetails');
    $router->get('/api/postapi','Api\\Curl@postApi');

});


