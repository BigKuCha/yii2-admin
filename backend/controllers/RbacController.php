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
use backend\models\TMenu;
use Yii;
use common\components\MyHelper;
use yii\data\ArrayDataProvider;
use yii\db\Query;

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
        $x = (new Query())->from('t_menu')->all();
        return print_r($x);
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $per = $auth->getPermission('test');
        $auth->addChild($role,$per);
        print_r($role);exit;
    }
    /**
     * 给角色分配权限
     * @return string
     */
    public function actionAssignauth()
    {
        if(Yii::$app->request->isPost)
        {
            $posts = Yii::$app->request->post();
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($posts['rolename']);
            $thismenu =TMenu::findOne($posts['menuid']);
            $route = $thismenu->route;
            if($posts['ck'])
            {
                if($posts['level']==3)
                {
                    //2级菜单
                    $father = $thismenu->father;
                    $fpermission = $auth->getPermission($father->route);
                    if(!$auth->hasChild($role,$fpermission))
                        $auth->addChild($role,$fpermission);
                    //1级菜单
                    $gpermission = $auth->getPermission($father->father->route);
                    if(!$auth->hasChild($role,$gpermission))
                        $auth->addChild($role,$gpermission);
                }
                if($posts['level']==2)
                {
                    //1级菜单
                    $fpermission = $auth->getPermission($thismenu->father->route);
                    if(!$auth->hasChild($role,$fpermission))
                        $auth->addChild($role,$fpermission);
                    //3级菜单
                    $children = $thismenu->son;
                    foreach($children as $son)
                    {
                        $sonpermission = $auth->getPermission($son->route);
                        if(!$auth->hasChild($role,$sonpermission))
                            $auth->addChild($role,$sonpermission);
                    }
                }
                if($posts['level']==1)
                {
                    //子子孙孙都加权限
                    $sons = $thismenu->son;
                    foreach($sons as $son)
                    {
                        $sonpermission = $auth->getPermission($son->route);
                        if(!$auth->hasChild($role,$sonpermission))
                            $auth->addChild($role,$sonpermission);
                        if($son->level==2)
                        {
                            $gsons = $son->son;
                            foreach($gsons as $gson)
                            {
                                $gsonpermission = $auth->getPermission($gson->route);
                                if(!$auth->hasChild($role,$gsonpermission))
                                    $auth->addChild($role,$gsonpermission);
                            }
                        }
                    }
                }
                //自身加入权限
                $permission = $auth->getPermission($route);
                    $auth->addChild($role,$permission);
            }

        }
        $list = TMenu::find()->where('level=1')->all();
        return $this->render('assignauth',[
            'list'=>$list,
            'rolename'=>Yii::$app->request->get('rolename'),
        ]);
    }
}