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
 *	 	┃　　 ┗━━━┓
 *	    ┃　　　　　　　┣┓
 *	    ┃　　　　　　　┏┛
 *	    ┗┓┓┏━┳┓┏┛
 *	      ┃┫┫　┃┫┫
 *	      ┗┻┛　┗┻┛
 */ 

namespace backend\controllers;

use kartik\widgets\ActiveForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\MethodNotAllowedHttpException;

class BackendController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions'=>['login'],
                        'allow'=>true,
                        'roles'=>['?'],
                    ],
                ],
                'denyCallback'=>function($rules, $action)
                {
                    Yii::$app->user->returnUrl = Yii::$app->request->url;
                    return $this->redirect(['user/login']);
                },
            ],
        ];
    }

    /**
     * 初始化
     */
    public function init()
    {
        Yii::$container->set('yii\widgets\LinkPager',[
            'firstPageLabel'=>'首页',
            'lastPageLabel'=>'尾页',
            'prevPageLabel'=>'上页',
            'nextPageLabel'=>'下页',
            'hideOnSinglePage'=>false,
            'options'=>[
                'class'=>'pagination pull-right'
            ],
        ]);
        Yii::$container->set('yii\data\Pagination',[
            'defaultPageSize'=>15
        ]);
        Yii::$container->set('yii\grid\GridView',[
            'layout'=>"{items}\n{pager}",
        ]);
        Yii::$container->set('yii\grid\ActionColumn',[
            'template'=>'{update} {delete}',
        ]);
        Yii::$container->set(ActiveForm::className(),[
            'type'=>ActiveForm::TYPE_HORIZONTAL,
        ]);
    }

    /**
     * 强制刷新菜单
     * @return \yii\web\Response
     */
    public function actionReflushmenu()
    {
        Yii::$app->session->setFlash('reflush');
        return $this->goHome();
    }
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        $route = Yii::$app->requestedRoute;
        //未加入权限控制的所有路由允许访问
        if(!Yii::$app->authManager->getPermission($route))
            return true;
        if(!Yii::$app->user->can($route))
            throw new MethodNotAllowedHttpException('未被授权！');
        return true;
    }
}