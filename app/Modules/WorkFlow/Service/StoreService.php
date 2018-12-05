<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/12/5
 * Time: 21:10
 */

namespace App\Modules\WorkFlow\Service;


use App\Common\Contracts\Service;
use App\Modules\WorkFlow\Repository\StoreRepo;
use App\Modules\WorkFlow\Repository\AdminUsersRepo;
use App\Modules\WorkFlow\Repository\AdminRolesRepo;

class StoreService extends Service
{
    public $user;
    public $roles;
    public function __construct(AdminUsersRepo $user,AdminRolesRepo $roles){
        $this->user = $user;
        $this->roles = $roles;
    }
    //状态 10 正常 20 关闭 30 热门  40 待审核 45 审核拒绝  50 禁用
    public function getRules()
    {
        // TODO: Implement getRules() method.
    }

    /**
     * @desc 店铺审核通过
     */
    public function storePass(StoreRepo $repo,$request)
    {
        /**
          Hash::make();
            dd(brcypt('123123'));
         */
        $params = [
            'status' => 10,
            'describe' => ''
        ];
        //更新状态
        $repo->update($request['id'],$params);
        //新增管理员用
        $storeInfo = $repo->getStoreInfo($request);
        $this->insertAdminUsers($storeInfo);
        return [
            'code'    => '0000',
            'message' => '提交成功!'
        ];
    }

    public function insertAdminUsers($storeInfo){
        $data = [
            'username' => $storeInfo['tel'],
            'password' => '123123',
            'name' => $storeInfo['name']
        ];
        //保存后返回ID
        $id = $this->user->insert($data);
        $this->insertAdminRoles($id);

    }

    public function insertAdminRoles($id){
        $data = [
            'user_id' => '6',//店主角色ID
            'role_id' => $id
        ];
        return $this->roles->insert($data);
    }

    /**
     * @desc 店铺审核拒绝
     */
    public function storeRefuse(StoreRepo $repo,$request){
        $params = [
            'status' => 45,
            'describe' => $request['text']
        ];
        $repo->update($request['id'],$params);
        return [
            'code'    => '0000',
            'message' => '提交成功!'
        ];
    }

    /**
     * @desc 店铺强制禁用
     */
    public function storeProhibit(StoreRepo $repo,$request){
        $params = [
            'status' => 50,
            'describe' => $request['text']
        ];
        $repo->update($request['id'],$params);
        return [
            'code'    => '0000',
            'message' => '提交成功!'
        ];
    }

    public function getStoreInfoBAdminUser(StoreRepo $repo,$request){
        return $repo->getStoreInfoBAdminUser($request);
    }
}