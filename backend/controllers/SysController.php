<?php
/**
 * Created by PhpStorm.
 * User: olebar
 * Date: 2014/10/22
 * Time: 16:30:15
 */

namespace backend\controllers;

use kartik\widgets\ActiveForm;
use Yii;
use backend\models\TMenu;
use yii\web\Response;

class SysController extends BackendController
{
    /**
     * 菜单管理
     * @return string
     */
    public function actionMenu()
    {
        $list = TMenu::find()->where('level=1')->all();
        return $this->render('menu',[
            'list'=>$list,
        ]);
    }
    /*
     * 添加菜单
     */
    public function actionMenumange()
    {
        $params = Yii::$app->request->get();
        if($params['id'])
            $model = TMenu::findOne($params['id']);
        else
        {
            $model = new TMenu();
            $model->parentid = $params['pid'];
            if($params['level']==0)
                $model->level = 1;
            if($params['level'==2])
                $model->level = 3;


        }

        return $this->render('menumange',[
            'model'=>$model,
        ]);
    }

    public function actionAjaxvalidate()
    {
        $model = new TMenu();
        if(Yii::$app->request->isAjax)
        {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model,'menuname');
        }
    }
} 