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

use backend\models\TMenu;
use kartik\widgets\ActiveForm;
use Yii;
use yii\caching\ChainedDependency;
use yii\caching\DbDependency;
use yii\caching\ExpressionDependency;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
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
            /*'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],*/
        ];
    }

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
        //获取、缓存菜单
        $key = 'menulist-'.Yii::$app->user->id;
        if(Yii::$app->session->getFlash('reflush') || !Yii::$app->cache->get($key))
        {
            $_list = $this->getMenulist();
            $dp = new ExpressionDependency([
                'expression'=>'count(Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id))'
            ]);
            $dp2 = new DbDependency([
                'sql'=>'select max(updated_at),count(name) from auth_item',
            ]);
            Yii::$app->cache->set($key,$_list,0,new ChainedDependency([
                'dependencies'=>[$dp,$dp2]
            ]));

        }else
            $_list = Yii::$app->cache->get($key);
        $this->view->params['menulist'] = $_list;
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
        if(!Yii::$app->authManager->getPermission($route))
            return true;
        return true;
    }
    public function getMenulist()
    {
        $list = TMenu::find()->where('level=1')->all();
        $menu = $this->renderPartial('@backend/views/home/_menu',[
           'list'=>$list,
        ]);
        return $menu;
    }

}