<?php
/**
 *      ┏┓　　　┏┓
 *    ┏┛┻━━━┛┻┓
 *    ┃　　　　　　　┃
 *    ┃　　　━　　　┃
 *    ┃　┳┛　┗┳　┃
 *    ┃　　　　　　　┃
 *    ┃　　　┻　　　┃
 *    ┃　　　　　　　┃
 *    ┗━┓　　　┏━┛
 *        ┃　　　┃   神兽保佑
 *        ┃　　　┃   代码无BUG！
 *         ┃　　　┗━━━┓
 *        ┃　　　　　　　┣┓
 *        ┃　　　　　　　┏┛
 *        ┗┓┓┏━┳┓┏┛
 *          ┃┫┫　┃┫┫
 *          ┗┻┛　┗┻┛
 */
namespace backend\controllers;

use backend\models\AuthItem;
use backend\models\TAdmUser;
use backend\models\TMenu;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Response;
use yii\widgets\ActiveForm;

class RbacController extends BackendController
{
    /**
     * 角色列表
     * @return string
     */
    public function actionRoles()
    {
        $roles = Yii::$app->authManager->getRoles();
        $dataprovider = new ArrayDataProvider([
            'allModels' => $roles,
        ]);
        return $this->render('roles', [
            'dataprovider' => $dataprovider,
        ]);
    }

    /**
     * 添加角色
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new AuthItem;
        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;
            $role = $auth->createRole($model->name);
            $role->description = $model->description;
            $auth->add($role);
            Yii::$app->session->setFlash('success');
            return $this->redirect(['rbac/roles']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = AuthItem::findOne($id);
        $request = Yii::$app->request;
        $auth = Yii::$app->authManager;
        if ($request->isPost && $model->load($request->post())) {
            $name = $model->oldAttributes['name'];
            $role = $auth->getRole($name);
            $role->name = $model->name;
            $role->description = $model->description;
            if ($auth->update($name, $role)) {
                Yii::$app->session->setFlash('success');
                return $this->redirect(['rbac/roles']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * 添加/修改角色
     * @return string
     */
    public function actionManagerole()
    {
        $request = Yii::$app->request;
        if ($rolename = $request->get('id')) {
            $model = AuthItem::findOne($rolename);
        } else {
            $model = new AuthItem();
        }
        if ($request->isPost) {
            $auth = Yii::$app->authManager;
            $model->load($request->post());
            if ($model->isNewRecord) {
                $role = $auth->createRole($model->name);
                $role->description = $model->description;
                $rzt = $auth->add($role);
            } else {
                $name = $model->oldAttributes['name'];
                $role = $auth->getRole($name);
                $role->name = $model->name;
                $role->description = $model->description;
                $rzt = $auth->update($name, $role);
            }
            if ($rzt) {
                Yii::$app->session->setFlash('success');
                return $this->redirect(['rbac/roles']);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除角色
     * @param $id
     * @return Response
     */
    public function actionDeleterole($id)
    {
        $role = Yii::$app->authManager->getRole($id);
        if (Yii::$app->authManager->remove($role)) {
            Yii::$app->session->setFlash('success');
        } else {
            Yii::$app->session->setFlash('fail', '角色删除失败');
        }
        return $this->redirect(['rbac/roles']);
    }

    /**
     * ajax验证角色是否存在
     * @return array
     */
    public function actionValidateitemname()
    {
        if ($name = $_REQUEST['id']) {
            $model = AuthItem::findOne($name);
        } else {
            $model = new AuthItem();
        }
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

    /**
     * 给角色分配权限
     * @return string
     */
    public function actionAssignauth()
    {
        if (Yii::$app->request->isPost) {
            $posts = Yii::$app->request->post();
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($posts['rolename']);
            $thismenu = TMenu::findOne($posts['menuid']);
            $route = $thismenu->route;
            $permission = $auth->getPermission($route);
            if ($posts['ck'] == 'true') {
                if ($posts['level'] == 3) {
                    //2级菜单
                    $father = $thismenu->father;
                    $fpermission = $auth->getPermission($father->route);
                    $this->addChild($role, $fpermission);
                    //1级菜单
                    $this->addChild($role, $auth->getPermission($father->father->route));
                }
                if ($posts['level'] == 2) {
                    //1级菜单
                    $fpermission = $auth->getPermission($thismenu->father->route);
                    $this->addChild($role, $fpermission);
                    //3级菜单
                    $children = $thismenu->son;
                    foreach ($children as $son) {
                        $this->addChild($role, $auth->getPermission($son->route));
                    }
                }
                if ($posts['level'] == 1) {
                    //子子孙孙都加权限
                    $sons = $thismenu->son;
                    foreach ($sons as $son) {
                        $this->addChild($role, $auth->getPermission($son->route));
                        if ($son->level == 2) {
                            $gsons = $son->son;
                            foreach ($gsons as $gson) {
                                $this->addChild($role, $auth->getPermission($gson->route));
                            }
                        }
                    }
                }
                //自身加入权限
                $auth->addChild($role, $permission);
            } else {
                if ($posts['level'] == 3 && $posts['cntlv3'] == 0) {
                    $father = $thismenu->father;
                    $auth->removeChild($role, $auth->getPermission($father->route));
                    if ($posts['cntlv3'] == 0) {
                        $auth->removeChild($role, $auth->getPermission($father->route));
                    }
                    if ($posts['cntlv2'] == 0) {
                        $auth->removeChild($role, $auth->getPermission($father->father->route));
                    }
                }
                if ($posts['level'] == 2) {
                    foreach ($thismenu->son as $son) {
                        $auth->removeChild($role, $auth->getPermission($son->route));
                    }
                    if ($posts['cntlv2'] == 0) {
                        $auth->removeChild($role, $auth->getPermission($thismenu->father->route));
                    }
                }
                if ($posts['level'] == 1) {
                    foreach ($thismenu->son as $son) {
                        $auth->removeChild($role, $auth->getPermission($son->route));
                        foreach ($son->son as $gson) {
                            $auth->removeChild($role, $auth->getPermission($gson->route));
                        }
                    }
                }
                //删除自身
                $auth->removeChild($role, $permission);
            }
        }
        $list = TMenu::find()->where('level=1')->all();
        $rolename = Yii::$app->request->get('rolename');
        $model = AuthItem::findOne($rolename);
        return $this->render('assignauth', [
            'list'     => $list,
            'rolename' => $rolename,
            'role'     => Yii::$app->authManager->getRole($rolename),
            'model'    => $model,
        ]);
    }

    /**
     * 给用户分配角色
     * @param $id
     * @return string
     */
    public function actionAssignrole($id)
    {
        $auth = Yii::$app->authManager;
        $model = TAdmUser::findOne($id);
        if (Yii::$app->request->isPost) {
            $action = Yii::$app->request->get('action');
            $roles = Yii::$app->request->post('roles');
            if ($action == 'assign') {
                foreach ($roles as $rolename) {
                    $role = $auth->getRole($rolename);
                    $auth->assign($role, $id);
                }
            } else {
                foreach ($roles as $rolename) {
                    $role = $auth->getRole($rolename);
                    $auth->revoke($role, $id);
                }
            }
            //所有角色
            $allroles = ArrayHelper::map($auth->getRoles(), 'name', 'name');
            //所有已选择的角色
            $selectedroles = ArrayHelper::map($auth->getRolesByUser($id), 'name', 'name');
            $res = [
                Html::renderSelectOptions('', array_diff($allroles, $selectedroles)),
                Html::renderSelectOptions('', $selectedroles)
            ];
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $res;
        }
        //获取已有角色
        $assignedroles = ArrayHelper::map($auth->getRolesByUser($id), 'name', 'name');
        //获取所有角色
        $allroles = ArrayHelper::map($auth->getRoles(), 'name', 'name');
        //未被选择的角色
        $roles = array_diff($allroles, $assignedroles);
        return $this->render('assignrole', [
            'roles'         => $roles,
            'assignedroles' => $assignedroles,
            'model'         => $model,
            'id'            => $id
        ]);
    }

    /**
     * 添加权限
     * @param $role
     * @param $item
     */
    protected function addChild($role, $item)
    {
        $auth = Yii::$app->authManager;
        if (!$auth->hasChild($role, $item)) {
            $auth->addChild($role, $item);
        }
    }
}