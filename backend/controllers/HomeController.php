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

use Yii;
use yii\caching\ChainedDependency;
use yii\caching\ExpressionDependency;
use yii\caching\DbDependency;
use backend\models\TMenu;
use yii\web\Controller;

class HomeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    public function actionIndex()
    {
        //缓存一个带有依赖的缓存
        $key = '_menu'.Yii::$app->user->id;
        if(!Yii::$app->cache->get($key))
        {
            $dp = new ExpressionDependency([
                'expression'=>'count(Yii::$app->authManager->getPermissionsByUser(Yii::$app->user->id))'
            ]);
            $dp2 = new DbDependency([
                'sql'=>'select max(updated_at),count(name) from auth_item',
            ]);
            Yii::$app->cache->set($key,'nothing',0,new ChainedDependency([
                'dependencies'=>[$dp,$dp2]
            ]));
            $_list = $this->getMenulist();
            Yii::$app->cache->set('menulist-'.Yii::$app->user->id,$_list,0);
        }
        return $this->render('index',[]);
    }
    //获取用户菜单
    protected  function getMenulist()
    {
        $list = TMenu::find()->where('level=1')->all();
        $menu = $this->renderPartial('@backend/views/home/_menu',[
            'list'=>$list,
        ]);
        return $menu;
    }
} 