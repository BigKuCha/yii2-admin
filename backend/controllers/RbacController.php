<?php
/**
 *	  ┏┓　　　┏┓
 *	┏┛┻━━━┛┻┓
 *	┃　　　　　　　┃
 *	┃　　　━　　　┃
 *	┃　┳┛　┗┳　┃
 *	┃　　　　　　　┃
 *	┃　　　┻　　　┃
 *	┃　　　　　　　┃
 *	┗━┓　　　┏━┛
 *	    ┃　　　┃   神兽保佑
 *	    ┃　　　┃   代码无BUG！
 *	 	 ┃　　　┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */
namespace backend\controllers;
header("Content-type:text/html;charset=utf-8");
use Yii;
use common\components\MyHelper;

class RbacController extends BackendController
{
    public $rzt;
    public function afterAction($action,$result)
    {
        return MyHelper::dump($this->rzt);
    }
    //添加角色
    public function actionAddrole()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole('admin');
        $role->description = '管理员';
        $this->rzt = $auth->add($role);
    }
    //给用户分配角色
    public function actionRoleuser()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $this->rzt = $auth->assign($role,1);
    }
    //添加权限
    public function actionAddpermission()
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission('rbac');
        $this->rzt = $auth->add($permission);
    }
    //给角色分配权限
    public function actionRolepermission()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $permission = $auth->getPermission('rbac');
        $this->rzt = $auth->addChild($role,$permission);
    }

} 