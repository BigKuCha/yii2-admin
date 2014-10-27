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
use yii\data\ArrayDataProvider;

class RbacController extends BackendController
{
    public function actionRoles()
    {
        $roles = Yii::$app->authManager->getRoles();
        $dataprovider = new ArrayDataProvider([
            'allModels'=>$roles,
        ]);
        return $this->render('roles',[
            'dataprovider'=>$dataprovider,
        ]);
    }

    public function actionAddrole()
    {
        return $this->render('addrole',[

        ]);
    }

    public function actionTest()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole('admin');
        $role->description = '系统管理员';
        $auth->add($role);
    }
}